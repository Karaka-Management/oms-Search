<?php
/**
 * Jingga
 *
 * PHP Version 8.2
 *
 * @package   Modules\Search
 * @copyright Dennis Eichhorn
 * @license   OMS License 2.2
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
 * @license OMS License 2.2
 * @link    https://jingga.app
 * @since   1.0.0
 */
final class ApiController extends Controller
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
     * Api method to handle basic search request
     *
     * @param HttpRequest      $request  Request
     * @param ResponseAbstract $response Response
     * @param array            $data     Generic data
     *
     * @return void
     *
     * @api
     *
     * @since 1.0.0
     */
    public function search(HttpRequest $request, ResponseAbstract $response, mixed $data = null) : void
    {
        $data = $this->routeSearch($request, $response, $data);

        if (empty($data)) {
            $this->fillJsonRawResponse($request, $response, []);
        }
    }
}
