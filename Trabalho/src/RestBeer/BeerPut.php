<?php

namespace RestBeer;

use Zend\Stdlib\Request;
use Zend\Stdlib\Response;

class BeerPut
{
    public function __invoke(Request $request, Response $response, callable $out = null)
    {
        $id = $request->getAttribute('id');

        parse_str(file_get_contents("php://input"),$data);
        $stmt = $db->prepare('update beer set name=:name, style=:style where id=:id');
        $stmt->bindParam(':name',$data['name']);
        $stmt->bindParam(':style', $data['style']);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $response->withStatus(204);
    }
}