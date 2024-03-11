<?php

namespace App\Http;

use Rareloop\Lumberjack\Helpers;
use Rareloop\Lumberjack\Http\Lumberjack as LumberjackCore;
use App\Menu\Menu;

class Lumberjack extends LumberjackCore
{
    public function addToContext($context)
    {
        $context['is_home'] = is_home();
        $context['is_front_page'] = is_front_page();
        $context['is_logged_in'] = is_user_logged_in();
        $context['menu'] = new Menu('main-nav');

        return $context;
    }

    public static function passwordRender($twigPath, $id)
    {
        return post_password_required($id) ? 'templates/errors/password.html.twig' : $twigPath;
    }
}
