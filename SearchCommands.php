<?php declare(strict_types=1);
return [
    '^:help .*$' => [
        0 => [
            'dest'       => '\Modules\Help\Controller\SearchController:searchHelp',
            'verb'       => 16,
            'permission' => [
                'module' => 'Help',
                'type'   => 2,
                'state'  => 2,
            ],
        ],
    ],
    '^:help :user .*$' => [
        0 => [
            'dest'       => '\Modules\Help\Controller\SearchController:searchHelp',
            'verb'       => 16,
            'permission' => [
                'module' => 'Help',
                'type'   => 2,
                'state'  => 2,
            ],
        ],
    ],
    '^:help :dev .*$' => [
        0 => [
            'dest'       => '\Modules\Help\Controller\SearchController:searchHelp',
            'verb'       => 16,
            'permission' => [
                'module' => 'Help',
                'type'   => 2,
                'state'  => 3,
            ],
        ],
    ],
    '^:help :module .*$' => [
        0 => [
            'dest'       => '\Modules\Help\Controller\SearchController:searchHelp',
            'verb'       => 16,
            'permission' => [
                'module' => 'Help',
                'type'   => 2,
                'state'  => 2,
            ],
        ],
    ],
    '^:goto .*$' => [
        0 => [
            'dest'       => '\Modules\Navigation\Controller\SearchController:searchGoto',
            'verb'       => 16,
            'permission' => [
                'module' => 'Navigation',
                'type'   => 2,
            ],
        ],
    ],
    '^:tag .*$' => [
        0 => [
            'dest' => '\Modules\Tasks\Controller\SearchController:searchTags',
            'verb' => 16,
            'permission' => [
                'module' => 'Tasks',
                'type' => 2,
            ],
        ],
    ],
];
