<?php
/**
 * Created by PhpStorm.
 * User: apiov
 * Date: 30/09/2017
 * Time: 15:48
 */

namespace RestBeer;

use Zend\Stratigility\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class Beer
{
    private $beers = [
        'brands' => ['Heineken', 'Guinness', 'Skol', 'Colorado'],
        'styles' => ['Pilsen' , 'Stout']
    ];

    public function __invoke($request, $response, $next)
    {
        $id = $request->getAttribute('id');

        if (!isset($this->beers['brands'][$id])) {
            return $response->withStatus(404);
        }

        $response->getBody()->write($this->beers['brands'][$id]);
        return $response;

    }
}