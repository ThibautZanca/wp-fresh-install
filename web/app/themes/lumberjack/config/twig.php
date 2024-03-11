<?php

/*
 * You can place your custom package configuration in here.
 */
return [
    'allowed_functions' => [
    ],
    'extensions' => [
        \App\TwigExtensions\TextExtension::class,
        \App\TwigExtensions\NewsExtension::class,
    ],
];
