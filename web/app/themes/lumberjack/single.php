<?php

/**
 * The Template for displaying all single posts
 */

namespace App;

use App\Http\Controllers\Controller;
use App\Http\Lumberjack;
use Rareloop\Lumberjack\Http\Responses\TimberResponse;
use Rareloop\Lumberjack\Post;
use Timber\Timber;

class SingleController extends Controller
{
    public function handle()
    {
        $context = Timber::get_context();
        $post = new Post();

        $context['post'] = $post;
        $context['title'] = $post->title;
        $context['content'] = $post->content;

        $template = Lumberjack::passwordRender('templates/standard/standard.html.twig', $post->ID);
        return new TimberResponse($template, $context);
    }
}
