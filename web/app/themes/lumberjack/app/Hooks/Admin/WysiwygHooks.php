<?php

namespace App\Hooks\Admin;

use Dugajean\WpHookAnnotations\Models\Action;
use Dugajean\WpHookAnnotations\Models\Filter;
use Dugajean\WpHookAnnotations\Models\Shortcode;

/**
 * Class ACFHooks
 * @see https://github.com/dugajean/wp-hook-annotations#usage
 * @package App\Hooks\Admin
 */
class WysiwygHooks
{

    /**
     * Change title page into custom placeholder
     * @Filter(tag="enter_title_here")
     */
    public static function customPlaceholder( $title ){
        // $screen = get_current_screen();
        // if  ($screen->post_type === "...")) {
        //     $title = __('My custom placeholder');
        // }
        // return $title;
    }

    /**
     * @Filter(tag="acf/fields/wysiwyg/toolbars")
     * @param array $toolbars
     * @return mixed
     */
    public static function wysiwygToolbars($toolbars)
    {
        $toolbars['without_headings'] = [];
        $toolbars['without_headings'][1] = ['bold' , 'italic' , 'underline', 'bullist', 'numlist', 'link', 'removeformat'];

        return $toolbars;
    }

    /**
     * Clean tinyMCE
     * @Filter(tag="mce_buttons")
     */
    public static function removeButtons($buttons)
    {
        $remove_buttons = array(
            'strikethrough',
            'blockquote',
            'hr', // horizontal line
            'alignleft',
            'aligncenter',
            'alignright',
            'wp_more', // read more link
            'spellchecker',
            'dfw', // distraction free writing mode
            'wp_adv', // kitchen sink toggle (if removed, kitchen sink will always display)
        );
        foreach ($buttons as $button_key => $button_value) {
            if (in_array($button_value, $remove_buttons)) {
                unset($buttons[$button_key]);
            }
        }
        return $buttons;
    }

    /**
     * Clean tinyMCE 2nd row
     * @Filter(tag="mce_buttons_2")
     */
    public static function removeButtonLine2($buttons)
    {
        $remove_buttons = array(
            'formatselect', // format dropdown menu for <p>, headings, etc
            'underline',
            'barrer',
            'strikethrough',
            'alignjustify',
            'forecolor', // text color
            'pastetext', // paste as text
            'charmap', // special characters
            'outdent',
            'indent',
            'undo',
            'redo',
            'hr',
            'wp_help', // keyboard shortcuts
        );
        foreach ($buttons as $button_key => $button_value) {
            if (in_array($button_value, $remove_buttons)) {
                unset($buttons[$button_key]);
            }
        }
        return $buttons;
    }

    /**
     * Remove heading useless
     * @Filter(tag="tiny_mce_before_init")
     */
    public static function removeHeadings($headings)
    {
        $headings['block_formats'] = 'Paragraph=p;Heading 2=h2;Heading 3=h3;Heading 4=h4;Heading 5=h5;';
        return $headings;
    }
    
}
