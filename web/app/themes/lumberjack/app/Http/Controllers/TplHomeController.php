<?php

namespace App\Http\Controllers;

class TplHomeController extends Controller
{
    const IS_PAGE = true;

    public static function getTemplateSlug(): string
    {
        return "tpl-home.php";
    }

    public static function getGutenbergTemplate()
    {
        $template = [
            // [
            //     'acf/header-block',
            //     []
            // ],
            // [
            //     'acf/title-text-block',
            //     []
            // ]
        ];

        return $template;
    }
}
