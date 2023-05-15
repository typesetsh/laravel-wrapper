<?php
/**
 * Copyright (c) 2020 Jacob Siefer
 * See LICENSE bundled with this package for license details.
 */
declare(strict_types=1);

namespace Typesetsh\LaravelWrapper\Pdf;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Contracts\View\View as HtmlView;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Typesetsh\LaravelWrapper\Typesetsh;

class View implements Renderable, Responsable
{
    /**
     * @var Typesetsh
     */
    private $pdf;

    /**
     * @var HtmlView
     */
    private $view;

    /**
     * @var string
     */
    private $filename;

    /**
     * @var bool
     */
    private $debug;

    public function __construct(HtmlView $view, Typesetsh $pdf, bool $debug = false)
    {
        $this->view = $view;
        $this->pdf = $pdf;
        $this->debug = $debug;
    }

    public function debug(bool $flag = true)
    {
        $this->debug = $flag;

        return $this;
    }

    public function forceDownload(string $filename): self
    {
        $this->filename = $filename;

        return $this;
    }

    public function toFile(string $filename): void
    {
        $html = $this->view->render();

        $this->pdf->render($html)->toFile($filename);
    }

    public function render(): string
    {
        $html = $this->view->render();

        return $this->pdf->render($html)->asString();
    }

    /**
     * Create an HTTP response that represents the object.
     *
     * @param Request $request
     */
    public function toResponse($request): Response
    {
        if ($this->debug) {
            return $this->toDebugResponse();
        }

        $html = $this->view->render();
        $result = $this->pdf->render($html);

        $cb = function () {
            echo $this->render();
        };

        $headers = [
            'Content-Type' => 'application/pdf',
        ];

        if ($this->filename) {
            $headers['Content-Disposition'] = 'attachment; filename='.$this->filename;
        }

        return response()->stream($cb, 200, $headers);
    }


    public function toDebugResponse()
    {
        $html = $this->view->render();
        $result = $this->pdf->render($html);

        $js = <<<HTML
        <script type="text/javascript">
            function emulatePrintMedia() {
                for (var sheet of document.styleSheets) {
                    for (var rule of sheet.cssRules) {
                        if (rule.type === CSSRule.MEDIA_RULE) {
                            if (rule.conditionText === 'print') {
                                rule.media.mediaText = 'screen';
                            } else if (rule.conditionText === 'screen') {
                                rule.media.mediaText = 'disabled';
                            } else if (rule.conditionText === 'prefers-color-scheme: dark') {
                                rule.media.mediaText = 'disabled';
                            }
                        }
                    }
                }
                for (var sheet of document.getElementsByTagName("link")) {
                    if (sheet.media === 'screen') {
                        sheet.disabled = true;
                    } else if (sheet.media === 'print') {
                        sheet.media = '';
                    }
                }
            }

            window.addEventListener('load', function() {
                emulatePrintMedia();
            });
        </script>
        HTML;

        $log = [];
        foreach( $result->issues as $issue) {
            $log[] = $issue->getMessage();
        }

        return response()->view('typesetsh::debug', [
            'result' => $result,
            'pdf' => $result->asString(),
            'html' => str_replace('<link ', '<link crossorigin ', $html).$js,
            'html_code' => $html,
            'log' => array_unique($log),
        ]);
    }
}
