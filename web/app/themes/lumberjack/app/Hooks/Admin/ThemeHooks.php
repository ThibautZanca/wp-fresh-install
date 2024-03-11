<?php

namespace App\Hooks\Admin;

use Dugajean\WpHookAnnotations\Models\Action;
use Dugajean\WpHookAnnotations\Models\Filter;
use Dugajean\WpHookAnnotations\Models\Shortcode;

/**
 * Class ThemeHooks
 * @see https://github.com/dugajean/wp-hook-annotations#usage
 * @package App\Hooks\Admin
 */
class ThemeHooks
{

    /**
     * Features for back office
     * @Action(tag="init")
     */
    public static function init() {
        remove_theme_support( 'post-thumbnails' );
    }

    /**
     * Remove comment from admin menu
     * @Action(tag="admin_menu", priority=15)
     */
    public static function removeCommentFromMenu()
    {
        remove_menu_page( 'edit-comments.php' );
        remove_submenu_page( 'themes.php', 'customize.php?return=' . urlencode($_SERVER['SCRIPT_NAME']));

        if (!is_super_admin()) {
            remove_menu_page( 'tools.php' );
        }
    }

    /**
     * Remove manage options from post (options in topbar)
     * @Action(tag="screen_options_show_screen")
     */
    public static function removeManageOptions() {
        if(!current_user_can('manage_options')) {
            return false;
        }
        return true;
    }

    /**
     * Remove metaboxes (ex: taxonomy choices on right side)
     * @Action(tag="admin_menu")
     */
    public static function removeMetaboxes() {
        // You can get the key by inspecting ID in the source code (F12)
        //remove_meta_box( 'tagsdiv-type', "my_post_type_name",'normal' );
    }

    /**
     * Remove all notices
     * @Action(tag="init", priority=100)
     */
    public static function removeAllNotices()
    {
        if (!is_super_admin()) {
            remove_all_actions('admin_notices');
        }
    }

    /**
     * @Action(tag="admin_enqueue_scripts")
     * @Action(tag="login_enqueue_scripts")
     */
    public static function themeStyle() {
        if (!current_user_can( 'manage_options' )) {

            // Remove metaboxes
            echo '<style>.update-nag, .updated, .error, .is-dismissible { display: none !important; }</style>';

            // Remove edit slug btn
            echo '<style>#edit-slug-buttons { display: none !important; }</style>';

            // Remove create media & post
            echo '<style>#wp-admin-bar-new-post, #wp-admin-bar-new-media { display: none !important; }</style>';

        }
    }

    /**
     * Supprimer l’entrée “Personnaliser” dans la top bar (FO)
     * @Action(tag="wp_before_admin_bar_render")
     */
    public static function beforeAdminMenuRender()
    {
        global $wp_admin_bar;
        if (!is_super_admin()) {
            $wp_admin_bar->remove_menu('customize');
        }
    }

    /**
     * Supprimer les entrées pour créer un nouveau média ou un nouvel article (quand on les désactives) depuis la top bar (FO)
     * @Action(tag="admin_bar_menu", priority=999)
     */
    public static function removeEntriesFromAdminBar()
    {
        global $wp_admin_bar;
        $wp_admin_bar->remove_node( 'new-post' );
        $wp_admin_bar->remove_node( 'new-media' );
    }

    /**
     * Supprimer Yoast du Dashboard
     * @Action(tag="wp_dashboard_setup")
     */
    public static function removeWpSeoDashboard() {
        // In some cases, you may need to replace 'side' with 'normal' or 'advanced'.
        remove_meta_box( 'wpseo-dashboard-overview', 'dashboard', 'side' );
    }

}
