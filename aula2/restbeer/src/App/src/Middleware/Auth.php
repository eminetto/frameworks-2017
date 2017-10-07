<?php

namespace App\Middleware;

use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;

class Auth implements MiddlewareInterface
{
    /**
     * {@inheritDoc}
     */
    public function process(ServerRequestInterface $request, DelegateInterface $delegate)
    {
        if (! $request->hasHeader('authorization')) {
            throw new \Exception('Unauthorized', 401);
        }

        if (!$this->isValid($request)) {
            throw new \Exception('Unauthorized', 403);
        }

        return $delegate->process($request);
    }

    private function isValid(ServerRequestInterface $request)
    {
        $token = $request->getHeader('authorization');
        if ($token[0] == 'cerveja') {
            return true;
        }
        return false;
    }
}