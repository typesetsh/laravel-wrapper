<?php
/**
 * @copyright Copyright (c) 2020 Jacob Siefer
 *
 * @see LICENSE
 */

namespace Typesetsh\LaravelWrapper\Facades;

use Typesetsh\LaravelWrapper\PdfView;

/**
 * @method static PdfView make($view, array $data = [], array $mergeData = [])
 */
class Pdf extends \Illuminate\Support\Facades\Facade
{
    public static function getFacadeAccessor()
    {
        return 'typesetsh.pdf';
    }
}
