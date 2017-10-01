<?php

namespace RestBeer;


use Zend\Stratigility\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class Brands implements MiddlewareInterface
{
    private $brands = ['Heineken', 'Guinness', 'Skol', 'Colorado'];

    public function __invoke(Request $request, Response $response, callable $out = null)
    {
        $response->getBody()->write(implode(',', $this->brands));
        return $out($request, $response);
    }

}