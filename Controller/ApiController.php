<?php
/**
 * Karaka
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

use phpOMS\Application\ApplicationAbstract;
use phpOMS\Message\Http\HttpRequest;
use phpOMS\Message\ResponseAbstract;
use phpOMS\Router\WebRouter;

/**
 * Api controller
 *
 * @package Modules\Search
 * @license OMS License 2.0
 * @link    https://jingga.app
 * @since   1.0.0
 */
final class ApiController extends Controller
{
    private $router = null;

    /**
     * {@inheritdoc}
     */
    public function __construct(ApplicationAbstract $app)
    {
        parent::__construct($app);

        $this->router = new WebRouter();
        $this->router->importFromFile(__DIR__ . '/../SearchCommands.php');
    }

    /**
     * Api method to handle basic search request
     *
     * @param HttpRequest      $request  Request
     * @param ResponseAbstract $response Response
     * @param mixed            $data     Generic data
     *
     * @return void
     *
     * @api
     *
     * @since 1.0.0
     */
    public function routeSearch(HttpRequest $request, ResponseAbstract $response, mixed $data = null) : void
    {
        $searchResults = $this->app->dispatcher->dispatch(
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
    }
}
