<?php
/**
 * Copyright (c) 2020 Jacob Siefer
 * See LICENSE bundled with this package for license details.
 */
declare(strict_types=1);

namespace Typesetsh\LaravelWrapper\Pdf;

use Illuminate\Contracts\View\Factory as ViewFactory;
use Typesetsh\LaravelWrapper\Typesetsh;

class Factory
{
    /**
     * @var Typesetsh
     */
    private $typesetsh;

    /**
     * @var ViewFactory
     */
    private $view;

    /**
     * @var bool
     */
    private $debug;

    public function __construct(Typesetsh $pdf, ViewFactory $view, bool $debug = false)
    {
        $this->typesetsh = $pdf;
        $this->view = $view;
        $this->debug = $debug;
    }

    /**
     * Get the evaluated view contents for the given view.
     *
     * @param string $view
     * @param \Illuminate\Contracts\Support\Arrayable|array $data
     * @param array $mergeData
     */
    public function make($view, $data = [], $mergeData = []): View
    {
        $view = $this->viewInstance($this->view->make($view, $data, $mergeData));

        return $view;
    }

    protected function viewInstance(\Illuminate\Contracts\View\View $view): View
    {
        return new View($view, $this->typesetsh, $this->debug);
    }
}
