<?php


namespace App\TwigExtensions;
use Timber\Timber;
use Twig\Extension\AbstractExtension;
use Rareloop\Lumberjack\Post;

class NewsExtension extends AbstractExtension
{
    /**
     * Adds functionality to Twig.
     *
     * @param \Twig\Environment $twig The Twig environment.
     * @return \Twig\Environment
     */
    public static function register($twig)
    {
        $twig->addFunction( new \Timber\Twig_Function("getLastNews" , [__CLASS__, 'getLastNews'] ));
        return $twig;
    }

    public static function getLastNews($customNews = null)
    {
        if($customNews){
            $lastNews =  Timber::get_posts($customNews);
        }else{
            $lastNews = Post::all(3, 'date', 'DESC');
        }

        return $lastNews;
    }

}
