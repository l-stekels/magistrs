<?php

/**
 * Returns the importmap for this application.
 *
 * - "path" is a path inside the asset mapper system. Use the
 *     "debug:asset-map" command to see the full list of paths.
 *
 * - "entrypoint" (JavaScript only) set to true for any module that will
 *     be used as an "entrypoint" (and passed to the importmap() Twig function).
 *
 * The "importmap:require" command can be used to add new entries to this file.
 */
return [
    'app' => [
        'path' => './assets/app.js',
        'entrypoint' => true,
    ],
    'bio_motion' => [
        'path' => './assets/bio_motion.js',
        'entrypoint' => true,
    ],
    'wheel' => [
        'path' => './assets/wheel.js',
        'entrypoint' => true,
    ],
    'fin' => [
        'path' => './assets/fin.js',
        'entrypoint' => true,
    ],
    'p5' => [
        'version' => '1.9.2',
    ],
    '@psychological-components/gew' => [
        'version' => '0.1.15',
    ],
    'rxjs/Observable' => [
        'version' => '5.5.12',
    ],
    'rxjs/Subject' => [
        'version' => '5.5.12',
    ],
    'rxjs/add/observable/fromEvent' => [
        'version' => '5.5.12',
    ],
    '@psychological-components/gew/lib/theme-core.css' => [
        'version' => '0.1.15',
        'type' => 'css',
    ],
    '@psychological-components/gew/lib/theme-rainbow.css' => [
        'version' => '0.1.15',
        'type' => 'css',
    ],
    '@psychological-components/gew/umd/gew.js' => [
        'version' => '0.1.15',
    ],
    'bmwalker' => [
        'path' => './assets/js/bmwalker.js',
    ],
    'chart.js' => [
        'version' => '4.4.2',
    ],
    '@kurkle/color' => [
        'version' => '0.3.2',
    ],
    'chart.js/auto' => [
        'version' => '4.4.2',
    ],
];
