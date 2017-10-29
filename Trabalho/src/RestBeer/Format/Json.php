<?php

namespace RestBeer\Format;

use Zend\Stratigility\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Zend\Diactoros\Response\JsonResponse;

class Json implements MiddlewareInterface
{
    public function __invoke(Request $request, Response $response, callable $out = null)
    {
        // $content = unserialize($response->getBody());
        $content = explode(',', $response->getBody());
        $header = $request->getHeader('accept');
        $accept = null;
        if (isset($header[0])) {
            $accept = $header[0];
        }
        if ($accept != 'application/json' ) {
            return $out($request, $response);
        }
        return new JsonResponse($content, $response->getStatusCode());
    }
}
