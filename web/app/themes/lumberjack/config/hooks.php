<?php

/*
 * You can place your custom package configuration in here.
 */
return [
    'register' => [
		App\Hooks\MediasHooks::class,
		App\Hooks\BrowserCheckHooks::class,
		App\Hooks\GlobalHooks::class,
		App\Hooks\Admin\ColumnsHooks::class,
		App\Hooks\Admin\ConfigHooks::class,
		App\Hooks\Admin\ThemeHooks::class,
		App\Hooks\Admin\WysiwygHooks::class,

		App\Hooks\Gutenberg\RestrictionsHooks::class,
        App\Hooks\Gutenberg\ThemeHooks::class,
        App\Hooks\Gutenberg\GeneralHooks::class,
		App\Hooks\Gutenberg\TemplateHooks::class

    ],
];
