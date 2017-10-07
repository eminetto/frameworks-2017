<?php

namespace App\Action\Beer;

use Interop\Http\ServerMiddleware\DelegateInterface;
use Psr\Http\Message\ServerRequestInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;

class Create implements MiddlewareInterface
{
    private $tableGateway;

    public function __construct($tableGateway)
    {
        $this->tableGateway   = $tableGateway;
    }

    public function process(ServerRequestInterface $request, DelegateInterface $delegate)
    {
        $data = $request->getParsedBody();

        $this->tableGateway->insert($data);

        return $delegate->process(
            $request->withParsedBody(
                ['id' => $this->tableGateway->getLastInsertValue()]
            )
        )->withStatus(201);
    }
}