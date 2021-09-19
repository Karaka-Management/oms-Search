<?php
/**
 * Orange Management
 *
 * PHP Version 8.0
 *
 * @package   Modules
 * @copyright Dennis Eichhorn
 * @license   OMS License 1.0
 * @version   1.0.0
 * @link      https://orange-management.org
 */
declare(strict_types=1);

use Modules\Search\Controller\ApiController;
use Modules\Search\Models\PermissionState;
use phpOMS\Account\PermissionType;
use phpOMS\Router\RouteVerb;

return [
    '^.*/search(\?.*|$)' => [
        [
            'dest'       => '\Modules\Search\Controller\ApiController:routeSearch',
            'verb'       => RouteVerb::ANY,
            'permission' => [
                'module' => ApiController::MODULE_NAME,
                'type'   => PermissionType::READ,
                'state'  => PermissionState::SEARCH,
            ],
        ],
    ],
];
