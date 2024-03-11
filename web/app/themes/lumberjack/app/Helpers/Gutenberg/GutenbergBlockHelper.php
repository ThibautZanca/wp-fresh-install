<?php

namespace App\Helpers\Gutenberg;

class GutenbergBlockHelper
{

    protected const CORE_BLOCK_PREFIX = 'core';
    protected const ACF_BLOCK_PREFIX = 'acf';

    public const DISALLOWED_BLOCKS = 'disallowed_blocks';
    public const ALLOWED_BLOCKS = 'allowed_blocks';

    /**
     * Get all Gutenberg defined blocks
     * @return array
     */
    public static function getAllBlocksList(): array
    {
        return array_keys(\WP_Block_Type_Registry::get_instance()->get_all_registered());
    }

    /**
     * @param string $prefix block prefix to retrieve list
     * @return array of block keys by prefix
     */
    protected static function getBlocksListWithPrefix(string $prefix): array
    {
        $registeredBlocks = self::getAllBlocksList();
        $blocks = [];
        if (is_iterable($registeredBlocks)) {
            foreach ($registeredBlocks as $blockName) {
                if (0 === strpos($blockName, $prefix)) {
                    $blocks[] = $blockName;
                }
            }
        }
        return $blocks;
    }

    /**
     * Get a array of all block names prefixed by core/*
     * @return array
     */
    public static function getCoreBlocksList(): array
    {
        return self::getBlocksListWithPrefix(self::CORE_BLOCK_PREFIX . '/');
    }

    /**
     * Get a array of all block names prefixed by acf/*
     * @return array
     */
    public static function getAcfBlocksList(): array
    {
        return self::getBlocksListWithPrefix(self::ACF_BLOCK_PREFIX . '/');
    }

    public static function commonsTemplate()
    {
        return [
            'page',
            'post'
        ];
    }


}