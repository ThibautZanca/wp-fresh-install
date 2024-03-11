<?php

namespace App\Hooks;

use Dugajean\WpHookAnnotations\Models\Action;
use Dugajean\WpHookAnnotations\Models\Filter;
use Dugajean\WpHookAnnotations\Models\Shortcode;

/**
 * Class MediasHooks
 * @see https://github.com/dugajean/wp-hook-annotations#usage
 * @package App\Hooks
 */
class MediasHooks
{

    /**
     * Custom image size
     * @Action(tag="init")
     */
    public static function imageSize() {
        //add_image_size('example', 600, 400 );
    }

    /**
     * Allowed SVG in media library
     * @Filter(tag="upload_mimes", priority=1, accepted_args=1)
     * @param $mime_types
     * @return mixed
     */
    public static function allowMimeTypes($mime_types)
    {
        $mime_types['svg'] = 'image/svg+xml';
        return $mime_types;
    }

}
