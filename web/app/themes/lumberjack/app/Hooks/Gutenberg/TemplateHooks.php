<?php


namespace App\Hooks\Gutenberg;

use Dugajean\WpHookAnnotations\Models\Filter;
use Dugajean\WpHookAnnotations\Models\Action;

class TemplateHooks
{
    private static function getConfig()
    {
        $postId =  isset($_GET['post']) ? $_GET['post'] : null;

        if (!is_admin() || !$postId) {
            return;
        }
        $configFile = 'templates.php';
        $configPath = get_template_directory(). '/config/gutenberg/' . $configFile;

        if (!file_exists($configPath)) {
            return;
        }
        $config = require $configPath;

        if (!is_array($config)) {
            return;
        }

        return $config;
    }

    /**
     * Set custom blocks template from config files to page templates
     * config file: get_template_directory(). '/config/templates.php'
     * https://developer.wordpress.org/block-editor/reference-guides/block-api/block-templates/
     *
     * @Action(tag="init")
     */
    public static function addBlockTemplateToPageTemplate()
    {
        $postId =  isset($_GET['post']) ? $_GET['post'] : null;

        $config = self::getConfig();
        if (!$config) {
            return;
        }

        $currentTemplate = get_page_template_slug($postId);

        if (!empty($config[$currentTemplate]) && !empty($config[$currentTemplate]['post_type'])) {

            $templateConfig = $config[$currentTemplate];

            $postTypes = $templateConfig['post_type'];
            if (is_string($postTypes)) {
                $postTypes = [$postTypes];
            }

            foreach ($postTypes as $postType) {
                $postTypeObject = get_post_type_object($postType);
                $assignProps = ['template', 'template_lock'];
                foreach ($assignProps as $prop) {
                    if (isset($templateConfig[$prop])) {
                        $postTypeObject->{$prop} = $templateConfig[$prop];
                    }
                }
            }
        }
    }

    /**
     *
     * Disable Gutenberg on page template or post id specified in config file
     * config file : get_template_directory(). '/config/templates.php'
     * key used : disable_gutenberg
     *
     * @Filter(tag="use_block_editor_for_post_type", priority=10,accepted_args=2)
     */
    public static function disabledGutenberg($canEdit, $postType = null)
    {
        $postId =  isset($_GET['post']) ? $_GET['post'] : null;

//        if ($postType === Review::getPostType()) return false;

        $config = self::getConfig();

        if (empty($config)) {
            return $canEdit;
        }

        $currentTemplate = get_page_template_slug($postId);

        if (!empty($config['disable_gutenberg'])
            && (in_array($currentTemplate, $config['disable_gutenberg'])
                || in_array(intval($postId), $config['disable_gutenberg']))) {
            return false;
        }

        return $canEdit;
    }
}
