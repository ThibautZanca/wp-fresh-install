<?php


namespace App\Http\Controllers;


use Rareloop\Lumberjack\Http\Responses\TimberResponse;
use Rareloop\Lumberjack\Post;
use Rareloop\Router\ControllerMiddlewareOptions;
use Timber\Timber;

class OldBrowserController extends Controller
{
    public function display()
    {
        $context = Timber::get_context();
        
        $context['lang'] = self::getLang('fr');
        $context['browers'] = self::getBrowserList();
        $context['hide_header'] = true;
        $context['hide_footer'] = true;

        return new TimberResponse('templates/errors/old-browser.html.twig', $context);
    }

    public static function getBrowserList(){
        $browser = [
            [
                "title" => "Google Chrome",
                "img" => mix('/build/images/browser/chrome.svg'),
                "link" => "https://www.google.com/intl/fr_fr/chrome/"
            ],
            [
                "title" => "Firefox",
                "img" => mix('/build/images/browser/firefox.svg'),
                "link" => "https://www.mozilla.org/fr/firefox/all/#product-desktop-release"
            ],
            [
                "title" => "Opera",
                "img" => mix('/build/images/browser/opera.svg'),
                "link" => "https://www.opera.com/fr"
            ],
            [
                "title" => "Microsoft Edge",
                "img" => mix('/build/images/browser/edge.svg'),
                "link" => "https://www.microsoft.com/fr-fr/windows/microsoft-edge"
            ]
        ];

        return $browser;
    }

    public static function getLang($currentLang = "fr"){
        $lang = [
            'fr' => [
                'title' => "Ce site est optimisé pour s’afficher sur les navigateurs les plus récents.",
                'desc' => "Afin de ne pas dégrader votre expérience, nous vous conseillons de télécharger la dernière version d’un des navigateurs suivants :"

            ],
            'en' => [
                'title' => "This website is optimized to work wirk the most recent browsers.",
                'desc' => "In order not to degrade your experience, we recommend to download the latest version of one of these browsers :"
            ],
            'de' => [
                'title' => "Diese Webseite ist für die neuesten Browser optimiert.",
                'desc' => "Um die Qualität Ihrer Erfahrung nicht zu beeinträchtigen, empfehlen wir Ihnen, die neueste Version einer der folgenden Browser herunterzuladen :"
            ]
        ];

        return $lang[$currentLang];
    }
}
