<?php

namespace App\Hooks\Admin;

use Dugajean\WpHookAnnotations\Models\Action;
use Dugajean\WpHookAnnotations\Models\Filter;
use Dugajean\WpHookAnnotations\Models\Shortcode;

/**
 * Class ConfigHooks
 * @see https://github.com/dugajean/wp-hook-annotations#usage
 * @package App\Hooks\Admin
 */
class ConfigHooks
{

    /**
     * @Action(tag="acf/init")
     */
    public static function googleApiKey()
    {
        if(function_exists("acf_update_setting")){
            acf_update_setting('google_api_key', (!empty(get_field("gmaps_key", "option")) ? get_field("gmaps_key", "option") : "") );
        }
    }

    /**
     * Set pretty permalinks
     * @Action(tag="after_switch_theme")¨
     */
    public static function prettyPermalinks() {
        global $wp_rewrite;
        $wp_rewrite->set_permalink_structure( '/%postname%/' );
        flush_rewrite_rules();
    }

    /**
     * @Action(tag="map_meta_cap", accepted_args=4)
     */
    public static function customManagePrivacyOptions($caps, $cap, $user_id, $args)
    {
        if ('manage_privacy_options' === $cap) {
            $manage_name = is_multisite() ? 'manage_network' : 'manage_options';
            $caps = array_diff($caps, [$manage_name]);
        }
        return $caps;
    }



    /**
     * @Filter(tag="redirection_role")
     */
    public static function accessRedirectionEditor() {
        return 'edit_pages';
    }

    /**
     * Ajout menu dans la sidebar pour les éditeurs
     * * @Action(tag="admin_menu")
     */
    public static function changeMenuPosition()
    {
      
        $userRole = get_role( 'editor' );
        if($userRole){
            $userRole->add_cap( 'edit_theme_options' );
        }
        
        // Remove old menu
        remove_submenu_page('themes.php', 'nav-menus.php');
        remove_menu_page('tools.php');

        //Add new menu page
        add_menu_page(
            'Menus',
            'Menus',
            'edit_theme_options',
            'nav-menus.php',
            '',
            'dashicons-list-view',
            68
        );

       /* add_menu_page(
            'Redirections',
            'Redirections',
            'edit_pages',
            'tools.php?page=redirection.php',
            '',
            'dashicons-admin-links',
            69
        ); */

        if (current_user_can('editor')){
            remove_menu_page( 'themes.php');
        }
    }

}
