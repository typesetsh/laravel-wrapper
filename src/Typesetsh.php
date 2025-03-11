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

    /** @var string */
    private $version;

    public function __construct(?callable $uriResolver = null, ?HtmlToPdf $html2pdf = null, string $version = '1.6')
    {
        $this->uriResolver = $uriResolver ?? UriResolver::httpOnly();
        $this->html2pdf = $html2pdf ?? new HtmlToPdf();
        $this->version = $version;
    }

    /**
     * Save handler are called prior to save and can manipulate
     * or append or validate the PDF document.
     *
     * @param callable(Pdf\Document) $saveHandler
     */
    public function with(callable $saveHandler): self
    {
        $name = "_with_". count($this->html2pdf->saveHandler);

        $self = clone $this;
        $self->html2pdf->saveHandler[$name] = $saveHandler;

        return $self;

    }

    public function render(string $html): Result
    {
        $result = $this->html2pdf->render($html, $this->uriResolver);
        $result->version = $this->version;

        // Append any issues from URI resolver to result
        if ($this->uriResolver instanceof UriResolver && $this->uriResolver->errors) {
            array_push($result->issues, ...$this->uriResolver->errors);
            $this->uriResolver->errors = [];
        }

        return $result;
    }

    /**
     * @param non-empty-list<string> $html
     */
    public function renderMultiple(array $html): Result
    {
        $result = $this->html2pdf->renderMultiple($html, $this->uriResolver);
        $result->version = $this->version;

        // Append any issues from URI resolver to result
        if ($this->uriResolver instanceof UriResolver && $this->uriResolver->errors) {
            array_push($result->issues, ...$this->uriResolver->errors);
            $this->uriResolver->errors = [];
        }

        return $result;
    }

    public function __clone(): void
    {
        $this->html2pdf = clone $this->html2pdf;
        $this->uriResolver = clone $this->uriResolver;
    }
}
