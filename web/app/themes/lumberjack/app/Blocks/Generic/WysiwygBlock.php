<?php

namespace App\Blocks;

use Adeliom\WP\Extensions\Blocks\AbstractBlock;
use App\Admin\Utils\Helpers;
use App\Enum\GutBlockName;
use WordPlate\Acf\Fields\Radio;
use WordPlate\Acf\Fields\Tab;
use WordPlate\Acf\Fields\Text;
use WordPlate\Acf\Fields\Wysiwyg;
use WordPlate\Acf\Fields\WysiwygEditor;

/**
 * Class WysiwygBlock
 * @see https://github.com/wordplate/extended-acf#fields
 * @package App\Admin
 */
class WysiwygBlock extends AbstractBlock
{

    public function __construct()
    {
        parent::__construct([
            'title'       => __('Texte centré'),
            'description' => __('Bloc de texte centré'),
            'category'    => GutBlockName::GENERIC,
            'post_types'  => Helpers::commonsTemplate(),
            'mode'           => 'edit'
        ]);
    }

    protected function registerFields(): \Traversable
    {
        yield Tab::make(__('Contenu'));
        yield WysiwygEditor::make(__("Description"), "text")
            ->tabs('visual')
            ->mediaUpload(false)
            ->required();

        yield \AcfUtils::button();

        yield Tab::make(__('Mise en page'));
        yield \AcfUtils::withBg();
    }

}
