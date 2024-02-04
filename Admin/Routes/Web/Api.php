<?php
/**
 * Jingga
 *
 * PHP Version 8.1
 *
 * @package   Modules
 * @copyright Dennis Eichhorn
 * @license   OMS License 2.0
 * @version   1.0.0
 * @link      https://jingga.app
 */
declare(strict_types=1);

use Modules\Search\Controller\ApiController;
use Modules\Search\Models\PermissionCategory;
use phpOMS\Account\PermissionType;
use phpOMS\Router\RouteVerb;

return [
    '^.*/search(\?.*|$)' => [
        [
            'dest'       => '\Modules\Search\Controller\ApiController:search',
            'verb'       => RouteVerb::ANY,
            'permission' => [
                'module' => ApiController::NAME,
                'type'   => PermissionType::READ,
                'state'  => PermissionCategory::SEARCH,
            ],
        ],
    ],
];
