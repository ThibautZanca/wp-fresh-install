<?php


namespace App\Repositories;

use Adeliom\WP\Extensions\PostTypes\Post as BasePost;
use Rareloop\Lumberjack\Post;
use Tightenco\Collect\Support\Collection;
use Timber\Timber;

/**
 * Class PostRepository
 * @package App\PostTypes
 */
class PostRepository extends BasePost
{
    public static function getPostType()
    {
        return 'post';
    }
    
}
