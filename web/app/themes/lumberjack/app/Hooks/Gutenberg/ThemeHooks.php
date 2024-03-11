<?php

namespace App\Hooks\Gutenberg;

use Dugajean\WpHookAnnotations\Models\Action;

/**
 * Cette classe est utilisée uniquement avec les blocs du core de Gutenberg
*/
class ThemeHooks
{


    /**
     * @Action(tag="after_setup_theme")
     */
    public static function themeInit()
    {

        //ajoute le style par défaut de WP pour les blocs (blockquote...)
        // add_theme_support( 'wp-block-styles' );

        // Suppression des couleurs sur mesure
        add_theme_support('disable-custom-colors');

        //alignement full pour les images
        add_theme_support('align-wide');

        //Désactiver la personnalisation de la taille de texte
        add_theme_support('disable-custom-font-sizes');
        add_theme_support('disable-custom-font-sizes');


        //Activer les styles pour thème sombre
        add_theme_support('editor-styles');
        add_theme_support('dark-editor-style');

        //Autoriser les embeds Responsives
        add_theme_support('responsive-embeds');


        //Désactiver l'option des dégradés (editor-gradient-presets si besoin d'en faire des customs)
        add_theme_support('disable-custom-gradient');

        //Suppression des blocs patterns par défaut proposés par WP
        remove_theme_support('core-block-patterns');

        //palette de couleurs
        add_theme_support('editor-color-palette', [
            [
                'name'  => __('Blanc', ''),
                'slug'  => 'white',
                'color' => '#fff',
            ],
            [
                'name'  => __('Noir', ''),
                'slug'  => 'black',
                'color' => '#000',
            ],
            [
                'name'  => __('Couleur principale', ''),
                'slug'  => 'secondary-01',
                'color' => '#1C50A1',
            ],
            [
                'name'  => __('Couleur secondaire', ''),
                'slug'  => 'secondary-02',
                'color' => '#0091DA',
            ],
            [
                'name'  => __('Gris 1', ''),
                'slug'  => 'gray-01',
                'color' => '#F5F5F5',
            ],
            [
                'name'  => __('Gris 3', ''),
                'slug'  => 'gray-03',
                'color' => '#E2F0F8',
            ],
        ]);

        //Personnaliser les tailles de texte proposées dans le paragraphe
        add_theme_support('editor-font-sizes', [
            [
                'name'      => __('Petite', ''),
                'shortName' => __('S', ''),
                'size'      => 12,
                'slug'      => 'small'
            ],
            [
                'name'      => __('Normale', ''),
                'shortName' => __('R', ''),
                'size'      => 16,
                'slug'      => 'regular'
            ],
            [
                'name'      => __('Moyenne', ''),
                'shortName' => __('M', ''),
                'size'      => 18,
                'slug'      => 'medium'
            ],
            [
                'name'      => __('Grande', ''),
                'shortName' => __('L', ''),
                'size'      => 21,
                'slug'      => 'large'
            ]
        ]);


        //Ajout pour les blocs de nouveaux styles
        $blocks = [
            'core/paragraph',
            'core/heading'
        ];

        $styles = [
            'h1' => 'Titre 1',
            'h2'=> 'Titre 2',
            'h3'=> 'Titre 3',
            'h4'=> 'Titre 4',
            'headline' => 'Titre 5'
        ];

        foreach ($blocks as $block) {
            foreach ($styles as $key => $value) {
                register_block_style($block, [
                    'name'  => $key,
                    'label' => $value
                ]);
            }
        }
    }

     /**
     * Remove bloc styles
     * @Action(tag="init")
     */
    public static function removeBlockStyle()
    {
        // Register the block editor script.
        wp_register_script('remove-block-style', mix("/scripts/editor.js"), [
            'wp-blocks',
            'wp-edit-post'
        ]);
        // register block editor script.
        register_block_type('remove/block-style', [
            'editor_script' => 'remove-block-style',
        ]);
    }

}
