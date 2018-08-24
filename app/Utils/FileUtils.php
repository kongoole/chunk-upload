<?php
/**
 * Date: 2018/8/24
 * Time: 17:00
 */

namespace App\Utils;

use Illuminate\Support\Facades\Storage;

class FileUtils
{
    public static function pathPrefix()
    {
        return Storage::disk('upload')->getDriver()->getAdapter()->getPathPrefix();
    }
}