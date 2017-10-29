<?php

namespace RestBeer;

class Brands implements MiddlewareInterface
{
    private $brands = ['Heineken', 'Guinness', 'Skol', 'Colorado'];

    public function __invoke(Request $request, Response $response, callable $out = null)
    {
        $response->getBody()->write(implode(',', $this->brands));
        return $out($request, $response);
    }

}