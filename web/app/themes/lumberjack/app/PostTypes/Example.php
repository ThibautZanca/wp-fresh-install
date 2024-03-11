<?php

namespace App\PostTypes;

use Adeliom\WP\Extensions\PostTypes\Post as BasePost;
use Closure;
use Timber\Timber;

/**
 * Class Example
 * @package App\PostTypes
 */
class Example extends BasePost
{
    /**
     * Return the key used to register the post type with WordPress
     *
     * @return string
     */
    public static function getPostType()
    {
        return 'inspiration';// (new \ReflectionClass(get_called_class()))->getShortName();
    }

    /**
     * Overwrite the post slug when a post is saved
     * https://github.com/mindkomm/types#register-post-types
     *
     * @return Closure
     */
    protected static function getPostTypeCustomSlug()
    {
        return function ($post_slug, $post_data, $post_id) {
            return $post_slug;
        };
    }

    /**
     * Return the config to use to register the post type with WordPress
     * https://github.com/mindkomm/types#register-post-types
     *
     * @return array
     */
    public static function getPostTypeConfig()
    {
        $labels = [
            // Le nom au pluriel
            'name' => _x('Inspirations', 'Post Type General Name'),
            // Le nom au singulier
            'singular_name' => _x('Inspiration', 'Post Type Singular Name'),
            // Le libellé affiché dans le menu
            'menu_name' => __('Inspirations'),
            // Les différents libellés de l'administration
            'all_items' => __('Toutes les inspirations'),
            'view_item' => __('Voir l\'inspiration'),
            'add_new_item' => __('Ajouter une inspiration'),
            'add_new' => __('Ajouter'),
            'edit_item' => __('Editer l\'inspiration'),
            'update_item' => __('Modifier l\'inspiration'),
            'search_items' => __('Rechercher une inspiration'),
            'not_found' => __('Non trouvée'),
            'not_found_in_trash' => __('Non trouvée dans la corbeille'),
        ];

        return [
            'name_plural' => __('Inspirations'),
            'args' => [
                /**
                 * For a list of possible menu-icons see
                 * https://developer.wordpress.org/resource/dashicons/
                 */
                'menu_icon' => 'dashicons-format-status',
                'hierarchical' => false,
                'has_archive' => false,
                'supports' => [
                    'title',
                    'excerpt',
                ],
                'labels' => $labels,
                // Whether post is accessible in the frontend
                'public' => true,
                'rewrite' => [
                    //'slug' => 'univers',
                    'with_front' => false
                ],
            ],
            'admin_columns' => [
                'date' => false, // Disable date in list view
            ],
        ];
    }

}
