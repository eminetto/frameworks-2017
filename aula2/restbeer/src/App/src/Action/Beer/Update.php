<?php

namespace App\Action\Beer;

use Interop\Http\ServerMiddleware\DelegateInterface;
use Psr\Http\Message\ServerRequestInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;

class Update implements MiddlewareInterface
{
    private $tableGateway;

    public function __construct($tableGateway)
    {
        $this->tableGateway   = $tableGateway;
    }

    public function process(ServerRequestInterface $request, DelegateInterface $delegate)
    {
        $id = $request->getAttribute('id');
        $beer = $this->tableGateway->select(
            ['id' => $id]
        );
        if (count($beer) == 0) {
            throw new \Exception("Not found", 404);
        }
        
        parse_str(file_get_contents("php://input"), $data);
        $this->tableGateway->update($data, ['id' => $id]);

        return $delegate->process(
            $request->withParsedBody(['id' => $id])
        );
    }
}
