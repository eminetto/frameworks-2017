<?php

namespace RestBeer;

use Zend\Stdlib\Request;
use Zend\Stdlib\Response;

class BeerPost
{
    public function __invoke(Request $request, Response $response, callable $out = null)
    {
        $db = new PDO('sqlite:beers.db');
        $db->exec(
            "create table if not exists 
beer (id INTEGER PRIMARY KEY AUTOINCREMENT, name text not null, style text not null)"
        );

        $data = $request->getParsedBody();
        $stmt = $db->prepare('insert into beer (name, style) values (:name, :style)');
        $stmt->bindParam(':name',$data['name']);
        $stmt->bindParam(':style', $data['style']);
        $stmt->execute();
        $data['id'] = $db->lastInsertId();
        if ($data['id'] == 0) {
            return $response->withStatus(500, "Erro salvando cerveja");
        }
        $response->getBody()->write($data['id']);

        return $response->withStatus(201);
    }
}