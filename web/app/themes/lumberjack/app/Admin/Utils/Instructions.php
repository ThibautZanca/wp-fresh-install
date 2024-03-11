<?php

namespace App\Admin\Utils;

use WordPlate\Acf\Fields\Message;

class Instructions
{
    /**
     * Returns image instructions text
     * @param int $width
     * @param int $height
     * @return string
     */
    public static function image(int $width, int $height): string
    {
        return apply_filters("adeliom_image_instruction", sprintf(__('Ratio d\'image recommandée :  %s pixels de largeur et %s de pixels de hauteur', "adeliom"), $width, $height), $width, $height);
    }

    /**
     * Generates instruction for shared block update
     * @param string $label
     * @param string $slug
     * @return Message
     */
    public static function sharedBlocks(string $label, string $slug = "page=blocs_partagés"): Message
    {
        return Message::make("Instruction", $label . "_message")
            ->message(__("Pour modifier cette section, veuillez cliquer <a href='/wp/wp-admin/admin.php?".$slug.">ici</a>"));
    }
}
