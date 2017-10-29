<?php

namespace RestBeer;

use Zend\Stratigility\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class Styles
{
    private $styles = ['Pilsen' , 'Stout'];

    public function __invoke(Request $request, Response $response, callable $out = null)
    {
        $response->getBody()->write(implode(',', $this->styles));
        return $out($request, $response);
    }
}