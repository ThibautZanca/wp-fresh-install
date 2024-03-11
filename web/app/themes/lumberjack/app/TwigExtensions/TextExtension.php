<?php
// File : app/TwigExtensions/BookISBNTwigExtension.php
namespace App\TwigExtensions;

use Twig\Extension\AbstractExtension;

/**
 * Class BookISBNTwigExtension
 * @package App\TwigExtensions
 */
class TextExtension extends  AbstractExtension
{
    /**
     * Adds functionality to Twig.
     *
     * @param \Twig\Environment $twig The Twig environment.
     * @return \Twig\Environment
     */
    public static function register($twig)
    {
        $twig->addFilter( new \Timber\Twig_Filter("truncatew" , [__CLASS__, 'truncatew'] ));
        return $twig;
    }

    public static function truncatew($string, $limit, $separator = '...')
    {
        if (mb_strlen($string) > $limit) {
            $newlimit = $limit - mb_strlen($separator);
            $s = mb_substr($string, 0, $newlimit + 1);

            return mb_substr($s, 0, mb_strrpos($s, ' ')) . $separator;
        }
        return $string;
    }

}

