<?php


namespace App\Hooks\Gutenberg;

use Dugajean\WpHookAnnotations\Models\Action;

class RestrictionsHooks
{

    /**
     *
     * Disable gutenberg blocks from post type
     * Restriction are defined in config files blocks.php
     *
     * @Action(tag="allowed_block_types_all", priority=10,accepted_args=2)
     */
    public static function allowedBlock($allowed_block_types, $post)
    {
        $allowed_block_types = \WP_Block_Type_Registry::get_instance()->get_all_registered();

        $postId = isset($_GET['post']) ? $_GET['post'] : null;

        $currentTemplate = get_page_template_slug($postId);
        $currentPostType = get_post_type($postId);

        $configFile = 'blocks.php';
        $configPath = get_template_directory() . '/config/gutenberg/' . $configFile;

        if (!file_exists($configPath)) {
            return;
        }

        $config = require $configPath;
        if (!is_array($config) || !isset($config['disallowed_blocks'])) {
            return;
        }

        $disallowed_blocks = isset($config['disallowed_blocks'][$currentPostType]) ? $config['disallowed_blocks'][$currentPostType] : null;

        if (!empty($currentTemplate) && isset($config['disallowed_blocks'][$currentTemplate])) {
            $disallowed_blocks = $config['disallowed_blocks'][$currentTemplate];
        }

        $allowed_blocks = !empty($config['allowed_blocks']) && isset($config['allowed_blocks'][$currentPostType]) ? $config['allowed_blocks'][$currentPostType] : [];




        if (!empty($disallowed_blocks) && is_array($disallowed_blocks)) {
            foreach ($disallowed_blocks as $block) {
                if ($block === "acf/all") {
                    foreach ($allowed_block_types as $key => $block_type) {
                        $in_array = is_array($allowed_blocks) ? in_array($key, $allowed_blocks) : false;
                        if (str_contains($key, "acf") && !$in_array) {
                            unset($allowed_block_types[$key]);
                        }
                    }
                } else {
                    unset($allowed_block_types[$block]);
                }
            }

            $allowed_block_types = array_keys($allowed_block_types);

            if (!empty($currentTemplate) && !empty($config['allowed_blocks']) && isset($config['allowed_blocks'][$currentTemplate])) {
                $allowed_blocks = $config['allowed_blocks'][$currentTemplate];
                foreach ($allowed_blocks as $block) {
                    $allowed_block_types[] = $block;
                }
            }


            return $allowed_block_types;
        }



        return array_keys($allowed_block_types);
    }
}
