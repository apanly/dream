<?php
/**
 * The manifest of files that are local to specific environment.
 * This file returns a list of environments that the application
 * may be installed under. The returned data must be in the following
 * format:
 *
 * ```php
 * return [
 *     'environment name' => [
 *         'path' => 'directory storing the local files',
 *         'setWritable' => [
 *             // list of directories that should be set writable
 *         ],
 *         'setExecutable' => [
 *             // list of files that should be set executable
 *         ],
 *         'setCookieValidationKey' => [
 *             // list of config files that need to be inserted with automatically generated cookie validation keys
 *         ],
 *         'createSymlink' => [
 *             // list of symlinks to be created. Keys are symlinks, and values are the targets.
 *         ],
 *     ],
 * ];
 * ```
 */
return [
    'Development' => [
        'path' => 'dev',
        'setWritable' => [
            'admin/runtime',
            'admin/web/assets',
            'api/runtime',
            'api/web/assets',
            'console/runtime',
            'console/web/assets',
            'blog/runtime',
            'blog/web/assets',
            'static/web/uploads',
            'common/logs'
        ],
        'setExecutable' => [
            'yii',
        ],
        'setCookieValidationKey' => [
            'api/config/main-local.php',
            'admin/config/main-local.php',
            'blog/config/main-local.php',
        ],
    ],
    'Production' => [
        'path' => 'prod',
        'setWritable' => [
            'admin/runtime',
            'admin/web/assets',
            'api/runtime',
            'api/web/assets',
            'console/runtime',
            'console/web/assets',
            'blog/runtime',
            'blog/web/assets',
            'static/web/uploads',
            'common/logs'
        ],
        'setExecutable' => [
            'yii',
        ],
        'setCookieValidationKey' => [
            'api/config/main-local.php',
            'admin/config/main-local.php',
            'blog/config/main-local.php',
        ],
    ],
];
