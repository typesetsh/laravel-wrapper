<?php
/**
 * Copyright (c) 2020 Jacob Siefer
 * See LICENSE bundled with this package for license details.
 */
declare(strict_types=1);

namespace Typesetsh\LaravelWrapper;

use Typesetsh\HtmlToPdf;
use Typesetsh\Result;
use Typesetsh\UriResolver;

/**
 * Typeset.sh pdf wrapper with a pre provided uri resolver.
 */
class Typesetsh
{
    /** @var HtmlToPdf */
    private $html2pdf;

    /** @var callable|UriResolver */
    private $uriResolver;

    public function __construct(callable $uriResolver = null, HtmlToPdf $html2pdf = null)
    {
        $this->uriResolver = $uriResolver ?? UriResolver::httpOnly();
        $this->html2pdf = $html2pdf ?? new HtmlToPdf();
    }

    public function render(string $html): Result
    {
        return $this->html2pdf->render($html, $this->uriResolver);
    }

    /**
     * @param non-empty-list<string> $html
     */
    public function renderMultiple(array $html): Result
    {
        return $this->html2pdf->renderMultiple($html, $this->uriResolver);
    }
}
