<?php

use App\Helpers\Gutenberg\GutenbergBlockHelper;

$disallowedEveryWhere = array_merge(
    GutenbergBlockHelper::getCoreBlocksList(), //add all core/* blocks name
    /*[
        'yoast-seo/breadcrumbs',
        'gravityforms/form'
    ],*/
);


// Use 'GutenbergBlockHelper::getAcfBlocksList()' to retrieve all ACF blocks

return [
    GutenbergBlockHelper::DISALLOWED_BLOCKS => [
        'page'                            => array_merge($disallowedEveryWhere, []),
        'post'                            => array_merge($disallowedEveryWhere, [])

    ],
   /* GutenbergBlockHelper::ALLOWED_BLOCKS    => [
        'home.php' => [],
    ]*/
];
