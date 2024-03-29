<?php

namespace App\Blocks;

use Adeliom\WP\Extensions\Blocks\AbstractBlock;
use App\Enum\GutBlockName;
use App\Helpers\Gutenberg\GutenbergBlockHelper;
use Traversable;
use WordPlate\Acf\Fields\Textarea;

/**
 * Class QuoteBlock
 * @see https://github.com/wordplate/extended-acf#fields
 * @package App\FlexibleLayout
 */
class QuoteBlock extends AbstractBlock
{

    public function __construct()
    {
        parent::__construct([
            'title' => __('Citation'),
            'description' => __('Bloc permettant la mise en avant d’un témoignage ou d’une citation'),
            'category'    => GutBlockName::LATEST,
            'post_types'  => GutenbergBlockHelper::commonsTemplate(),
            'mode'           => 'edit'
        ]);
    }

    /**
     * @return Traversable
     */
    protected function registerFields(): \Traversable
    {
        yield Textarea::make(__("Citation"), "text")->rows(2)->required();
    }
}
