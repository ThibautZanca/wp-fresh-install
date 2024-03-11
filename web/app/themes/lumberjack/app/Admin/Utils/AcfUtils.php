<?php


use BaseTheme\Classes\Admin\AcfToolkit;
use WordPlate\Acf\Fields\Link;
use WordPlate\Acf\Fields\RadioButton;


class AcfUtils
{

    /**
     * default button
     * @param null $textDefault
     * @param string $prefix
     * @return \WordPlate\Acf\Fields\Attributes\Instructions|\WordPlate\Acf\Fields\Field|Link
     */
    public static function button($textDefault = null, $prefix = "btn_")
    {
        $textDefault = !empty($textDefault) ? $textDefault : __('Lire plus');

        return Link::make('Bouton', $prefix . 'link')
            ->instructions(__('Si le "Texte du lien" n\'est pas rempli, la valeur par défaut sera : "' . $textDefault . '""', ''));
    }

    /*
     * Usefull for background
     */
    public static function withBg(){
        return RadioButton::make(__('Couleur de fond'), 'bg')
            ->instructions('Sélectionnez la couleur de fond de ce bloc.')
            ->choices([
                'no-bg' => __('Sans fond'),
                'on-dark' =>  __('Fond foncé'),
            ])
            ->defaultValue('no-bg')
            ->returnFormat('value') // array, label or value (default)
            ->required();
    }

    /**
     * Function to merge fields and add button at the end
     * @param $subFields
     * @return array
     */
    public static function addButton($subFields)
    {
        return array_merge($subFields, self::button());
    }

}
