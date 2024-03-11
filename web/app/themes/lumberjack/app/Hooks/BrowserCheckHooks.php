<?php

namespace App\Hooks;

use Dugajean\WpHookAnnotations\Models\Action;
use Dugajean\WpHookAnnotations\Models\Filter;
use Dugajean\WpHookAnnotations\Models\Shortcode;
use Rareloop\Lumberjack\Facades\Config;
use Zend\Diactoros\Response\RedirectResponse;

/**
 * Class BrowserCheckHooks
 * @see https://github.com/dugajean/wp-hook-annotations#usage
 * @package App\Hooks
 */
class BrowserCheckHooks
{

    const COOKIE_NAME = "IE_CHECK";

    /**
     * @Action(tag="template_redirect")
     */
    public static function odlBrowserHandler()
    {
        $ua = htmlentities($_SERVER['HTTP_USER_AGENT'], ENT_QUOTES, 'UTF-8');

        if (
            !empty(filter_var($_ENV["IE_REDIRECT"] ?? true, FILTER_VALIDATE_BOOLEAN)) &&
            (
                preg_match('~MSIE|Internet Explorer~i', $ua) ||
                (strpos($ua, 'Trident/7.0; rv:11.0') !== false)
            )
        ) {
            if (!isset($_COOKIE[self::COOKIE_NAME])) {
                setcookie(self::COOKIE_NAME, true, time() + (86400 * 30), "/");
                wp_redirect(route("errors.old-browser"));
                exit();
            }
        }
    }
}
