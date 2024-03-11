<?php


namespace App\Repositories;

use Adeliom\WP\Extensions\PostTypes\Post as BasePost;

class PageRepository extends BasePost
{
    public static function getPostType()
    {
        return 'page';
    }
}
