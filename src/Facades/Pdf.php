<?php
/**
 * Copyright (c) 2020 Jacob Siefer
 * See LICENSE bundled with this package for license details.
 */
declare(strict_types=1);

namespace Typesetsh\LaravelWrapper\Facades;

use Typesetsh\LaravelWrapper\Pdf\View;

/**
 * @method static View make($view, array $data = [], array $mergeData = [])
 */
class Pdf extends \Illuminate\Support\Facades\Facade
{
    public static function getFacadeAccessor()
    {
        return 'typesetsh.pdf';
    }
}
