<?php

namespace App\Admin;

use Adeliom\WP\Extensions\Admin\AbstractAdmin;

use App\FlexibleLayout\CtaCardsLayout;
use Traversable;
use WordPlate\Acf\ConditionalLogic;
use WordPlate\Acf\Fields\Email;
use WordPlate\Acf\Fields\FlexibleContent;
use WordPlate\Acf\Fields\Group;
use WordPlate\Acf\Fields\Image;
use WordPlate\Acf\Fields\Link;
use WordPlate\Acf\Fields\PostObject;
use WordPlate\Acf\Fields\Relationship;
use WordPlate\Acf\Fields\Select;
use WordPlate\Acf\Fields\Tab;
use WordPlate\Acf\Fields\Text;
use WordPlate\Acf\Fields\Textarea;
use WordPlate\Acf\Fields\TrueFalse;
use WordPlate\Acf\Location;

/**
 * Class SharedBlockAdmin
 * @package App\Admin
 */
class ParametersAdmin extends AbstractAdmin
{

    public static function getTitle(): string
    {
        return __('Paramètres');
    }


    public static function getSlug(): string
    {
        return 'paramètres';
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

    protected static function getForms() {
        return [
            'quotation' => 'Demande de devis'
        ];
    }

    protected static function getFormsID()
    {
        $choices = [];
        if ( class_exists( 'GFFormsModel' ) ) {
            foreach ( \GFFormsModel::get_forms() as $form ) {
                $choices[ $form->id ] = $form->title;
            }
        }
        return $choices;
    }

    /**
     * @see https://github.com/wordplate/extended-acf#fields
     * @return Traversable
     */
    public static function getFields(): Traversable
    {

        yield Tab::make(__("Liens"));
        yield Group::make("Liens du site", "link")
            ->instructions('Renseignez les liens des pages concernées')
            ->fields([
                PostObject::make('Page example', 'example')->postTypes(['page'])->required()
            ])
            ->layout('row');

        $forms = [];
        foreach (self::getForms() as $key => $label) {
            $forms[] = Select::make($label, $key)->choices(self::getFormsID())->required();
        }

        yield Tab::make(__("Formulaires"));
        yield Group::make("Formulaires", "form")
            ->instructions('Sélectionnez les formulaires concernés')
            ->fields($forms)
            ->layout('row');

        /* A utiliser lorsque les mails sont envoyés manuellement */

        /*yield Tab::make(__("Emails"), 'emails_tab');
        yield Group::make("Emails", "emails")
            ->fields([
                TrueFalse::make('Activer le debug', 'debug')
                    ->defaultValue(false)
                    ->stylisedUi(),
                Email::make('Email(s) de test', 'email_debug')
                    ->instructions("Saisir un ou plusieurs emails séparé d'une virgule")
                    ->conditionalLogic([
                        ConditionalLogic::if('debug')->equals(1)
                    ])
            ])
            ->layout('row');*/

        yield Tab::make(__("Autres"));
        yield Group::make("Configuration", "config")
            ->fields([
                Text::make('Clé google maps', 'gmap')->required(),
            ])
            ->layout('row');
    }

    /**
     * Register option page settings
     * @see https://github.com/soberwp/intervention/blob/master/.github/add-acf-page.md
     * @return array
     */
    public static function setupOptionPage(): array
    {
        return [
            "settings" => "Paramètres",
            "roles" => ['admin', 'editor'],
            "icon_url"    => "dashicons-schedule"
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
