<?php

namespace App\Admin;

use Adeliom\WP\Extensions\Admin\AbstractAdmin;

use Adeliom\Acf\Fields\IconPicker;
use Traversable;
use WordPlate\Acf\Fields\Group;
use WordPlate\Acf\Fields\Image;
use WordPlate\Acf\Fields\Link;
use WordPlate\Acf\Fields\Tab;
use WordPlate\Acf\Fields\Text;
use WordPlate\Acf\Fields\Textarea;
use WordPlate\Acf\Location;
use WordPlate\Acf\Fields\Repeater;

/**
 * Class SharedBlockAdmin
 * @package App\Admin
 */
class SharedBlockAdmin extends AbstractAdmin
{

    public static function getTitle(): string
    {
        return __('Blocs partagés');
    }


    public static function getSlug(): string
    {
        return 'blocs_partagés';
    }


    /**
     * Register has option page
     * @return bool
     */
    public static function hasOptionPage(): bool
    {
        return true; // false by default
    }

    public static function getStyle(): string
    {
        return 'default';
    }

    /**
     * @see https://github.com/wordplate/extended-acf#fields
     * @return Traversable
     */
    public static function getFields(): Traversable
    {

        /* EXAMPLE TO OVERRIDE */
        yield Tab::make(__("À votre écoute"));
        yield Group::make("À votre écoute", "service")
            ->instructions('Renseignez les données relatives au bloc "À votre écoute"')
            ->fields([
                Text::make(__('Titre'), 'title'),
                Textarea::make(__('Contenu'), 'content'),
                Image::make('Image latérale', 'image')
                    ->instructions(__('Ratio de l’image recommandée : 750 x 430'))
            ])
            ->layout('row')
        ;

    }

    /**
     * Register option page settings
     * @see https://github.com/soberwp/intervention/blob/master/.github/add-acf-page.md
     * @return array
     */
    public static function setupOptionPage(): array
    {
        return [
            "settings" => "Blocs partagés",
            "roles" => ['admin', 'editor']
        ];
    }

    /**
     * @see https://github.com/wordplate/extended-acf#location
     * @return Traversable
     */
    public static function getLocation(): Traversable
    {
        yield Location::if('options_page', self::getSlug());
    }
}
