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

    public function __construct(HtmlView $view, Typesetsh $pdf)
    {
        $this->view = $view;
        $this->pdf = $pdf;
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
    public function toResponse($request): StreamedResponse
    {
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
}
