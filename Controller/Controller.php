<?php
/**
 * Jingga
 *
 * PHP Version 8.1
 *
 * @package   Modules\Search
 * @copyright Dennis Eichhorn
 * @license   OMS License 2.0
 * @version   1.0.0
 * @link      https://jingga.app
 */
declare(strict_types=1);

namespace Modules\Search\Controller;

use Modules\Search\Models\Search;
use phpOMS\Message\Http\HttpRequest;
use phpOMS\Message\ResponseAbstract;
use phpOMS\Module\ModuleAbstract;
use phpOMS\Router\RouterInterface;

/**
 * Search class.
 *
 * @package Modules\Search
 * @license OMS License 2.0
 * @link    https://jingga.app
 * @since   1.0.0
 */
class Controller extends ModuleAbstract
{
    /**
     * Module path.
     *
     * @var string
     * @since 1.0.0
     */
    public const PATH = __DIR__ . '/../';

    /**
     * Module version.
     *
     * @var string
     * @since 1.0.0
     */
    public const VERSION = '1.0.0';

    /**
     * Module name.
     *
     * @var string
     * @since 1.0.0
     */
    public const NAME = 'Search';

    /**
     * Module id.
     *
     * @var int
     * @since 1.0.0
     */
    public const ID = 1007600000;

    /**
     * Providing.
     *
     * @var string[]
     * @since 1.0.0
     */
    public static array $providing = [
    ];

    /**
     * Dependencies.
     *
     * @var string[]
     * @since 1.0.0
     */
    public static array $dependencies = [];

    protected ?RouterInterface $router = null;

    /**
     * Api method to handle basic search request
     *
     * @param HttpRequest      $request  Request
     * @param ResponseAbstract $response Response
     * @param array            $data     Generic data
     *
     * @return array
     *
     * @api
     *
     * @since 1.0.0
     */
    public function routeSearch(HttpRequest $request, ResponseAbstract $response, mixed $data = null) : array
    {
        if ($this->router === null) {
            return [];
        }

        $this->app->dispatcher->dispatch(
            $this->router->route(
                $request->getDataString('search') ?? '',
                $request->getDataString('CSRF'),
                $request->getRouteVerb(),
                $this->app->appId,
                $this->app->unitId,
                $this->app->accountManager->get($request->header->account)
            ),
            $request,
            $response
        );

        return $response->data;
    }
}
