<?php

namespace App\Hooks\Admin;

use Dugajean\WpHookAnnotations\Models\Action;
use Dugajean\WpHookAnnotations\Models\Filter;
use Rareloop\Lumberjack\QueryBuilder;

/**
 * Class ColumnsHooks
 * @see https://github.com/dugajean/wp-hook-annotations#usage
 * @package App\Hooks
 */
class ColumnsHooks
{

    /**
     * Display custom columns in "xxx" list
     * @Filter(tag="manage_xxx_posts_columns")
     */
    public static function addCustomColumn($column) {
        $column['my_field_key'] = 'My field';
        return $column;
    }

    /**
     * Display custom columns in "xxx" list
     * @Filter(tag="manage_edit-xxx_sortable_columns")
     */
    public static function sortCustomColumn( $columns ) {
        $columns['my_field_key'] = 'My field';
        return $columns;
    }

    /**
     * Render data in custom columns
     * @Filter(tag="manage_xxx_posts_custom_column", accepted_args=2, priority=10)
     */
    public static function custom_column($column, $post_id) {
        switch ($column) {
            case 'my_field_key' :
                $example = get_field('my_field_key', $post_id);
                echo $example->post_title;
                break;
            default:
                echo '';
        }
    }

}
