<?php
/**
 * Jingga
 *
 * PHP Version 8.2
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
use phpOMS\Contract\RenderableInterface;
use phpOMS\Message\Http\HttpRequest;
use phpOMS\Message\RequestAbstract;
use phpOMS\Message\ResponseAbstract;
use phpOMS\Router\WebRouter;
use phpOMS\Views\View;

/**
 * Backend controller
 *
 * @package Modules\Search
 * @license OMS License 2.0
 * @link    https://jingga.app
 * @since   1.0.0
 */
final class BackendController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function __construct(ApplicationAbstract $app)
    {
        parent::__construct($app);

        $this->router = new WebRouter();
        $this->router->importFromFile(__DIR__ . '/../Admin/SearchCommands.php');
    }

    /**
     * Backend method to handle basic search request
     *
     * @param HttpRequest      $request  Request
     * @param ResponseAbstract $response Response
     * @param array            $data     Generic data
     *
     * @return RenderableInterface
     *
     * @api
     *
     * @since 1.0.0
     */
    public function search(HttpRequest $request, ResponseAbstract $response, array $data = []) : RenderableInterface
    {
        $view = new View($this->app->l11nManager, $request, $response);
        $view->setTemplate('/Modules/Search/Theme/Backend/search-result');

        $internalRequest  = clone $request;
        $internalResponse = clone $response;

        $internalResponse->header = clone $request->header;

        $internalResponse->data = [];

        $temp       = empty($request->getDataString('search')) ? [] : $this->routeSearch($internalRequest, $internalResponse, $data);
        $view->data = empty($temp) ? [] : \reset($temp);

        return $view;
    }
}
