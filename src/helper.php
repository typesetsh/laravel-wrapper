<?php
/**
 * Copyright (c) 2020 Jacob Siefer
 * See LICENSE bundled with this package for license details.
 */
declare(strict_types=1);

namespace Typesetsh;

use Typesetsh\LaravelWrapper\Pdf;

/**
 * Get the evaluated pdf contents for the given view.
 *
 * @param string|null $view
 * @param \Illuminate\Contracts\Support\Arrayable|array $data
 * @param array $mergeData
 *
 * @return Pdf\Factory|Pdf\View
 */
function pdf($view = null, $data = [], $mergeData = [])
{
    /** @var Pdf\Factory $factory */
    $factory = app()->get('typesetsh.pdf');

    if (func_num_args() === 0) {
        return $factory;
    }

    return $factory->make($view, $data, $mergeData);
}
