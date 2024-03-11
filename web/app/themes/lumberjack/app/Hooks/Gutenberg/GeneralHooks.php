<?php

namespace App\Hooks\Gutenberg;
use Dugajean\WpHookAnnotations\Models\Filter;
use Dugajean\WpHookAnnotations\Models\Action;

class GeneralHooks
{

    /**
     * Ajouter une feuille de style pour l’éditeur dans l’admin
     * @Action(tag="enqueue_block_editor_assets")
     */
    public static function editorStyle()
    {
        wp_enqueue_style(
            'editor',
            get_theme_file_uri('/build/styles/editor.css'),
            false
        );
    }

    /**
     * Ajout d'un nouveau type de catégorie dans les blocs GUT
     * @Filter(tag="block_categories_all", priority=10,accepted_args=2)
     */
    public static function blockCategory($categories, $post)
    {
        return array_merge(
            $categories,
            [
                [
                    'slug'  => 'latest',
                    'title' => __('Remontées automatiques', ''),
                    'icon'  => 'images-alt',
                ],
                [
                    'slug'  => 'shared-block',
                    'title' => __('Bloc partagé', ''),
                    'icon'  => '',
                ],
                [
                    'slug'  => 'other',
                    'title' => __('Autre', ''),
                ]
            ]
        );
    }

}
