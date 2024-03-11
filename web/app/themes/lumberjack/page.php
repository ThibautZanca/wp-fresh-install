<?php

/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 */

namespace App;

use App\Http\Controllers\Controller;
use App\Http\Lumberjack;
use Rareloop\Lumberjack\Http\Responses\TimberResponse;
use Rareloop\Lumberjack\Page;
use Timber\Timber;

class PageController extends Controller
{
    public function handle()
    {
        $context = Timber::get_context();
        $page = new Page();

        $context['post'] = $page;
        $context['title'] = $page->title;
        $context['content'] = $page->content;
        $context['flex_content'] =  $page->meta('flex_content');

        $template = Lumberjack::passwordRender('templates/standard/standard.html.twig', $page->ID);
        return new TimberResponse($template, $context);
    }
}
