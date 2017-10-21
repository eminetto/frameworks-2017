<?php

namespace RestBeer;

use Firebase\JWT\JWT;
use Zend\Stratigility\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class Auth implements MiddlewareInterface
{
    public function __invoke(Request $request, Response $response, callable $out = null)
    {
        if ($request->getUri()->getPath() == '/login') {
            return $out($request, $response);
        }
        if (!$request->hasHeader('authorization')) {
            return $response->withStatus(401);
        }

        if (!$this->isValid($request)) {
            return $response->withStatus(403);
        }

        return $out($request, $response);
    }

    private function isValid(Request $request)
    {
        $token = $request->getHeader('authorization');

        try {
            JWT::decode($token[0], "webdev2017", array("HS256"));
            return true;
        } catch (\Exception $exc) {
            return false;
        }
    }
}
