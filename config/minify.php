<?php
/*
 * This file is part of Minify.
 *
 * (c) Haries Nur Ikhwan <haries@telcolab.my>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
return [
    /*
    |--------------------------------------------------------------------------
    | Automatic Blade Optimizations
    |--------------------------------------------------------------------------
    |
    | This option enables minification of the blade views as they are
    | compiled. These optimizations have little impact on php processing time
    | as the optimizations are only applied once and are cached. This package
    | will do nothing by default to allow it to be used without minifying
    | pages automatically.
    |
    | Default: false
    |
     */
    'enabled' => false,

    /*
    |--------------------------------------------------------------------------
    | Ignore Blade Files
    |--------------------------------------------------------------------------
    |
    | Here you can specify paths, which you don't want to minify.
    |
     */
    'ignore'  => [
        'resources/views/emails',
        'resources/views/html',
        'resources/views/notifications',
        'resources/views/markdown',
        'resources/views/vendor/emails',
        'resources/views/vendor/html',
        'resources/views/vendor/notifications',
        'resources/views/vendor/markdown',
    ],
];
