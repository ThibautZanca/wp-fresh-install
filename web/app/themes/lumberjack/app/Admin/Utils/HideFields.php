<?php


namespace App\Admin\Utils;

class HideFields
{
    /**
     * @return array|string[]
     */
    public static function make()
    {

        return [
            "the_content",
            "excerpt",
            "discussion",
            "comments",
            "slug",
            "author",
            "format",
            "page_attributes",
            "categories",
            "tags",
            "send-trackbacks",
            "featured_image",
            //'permalink',
            //'revisions',
        ];
    }
}
