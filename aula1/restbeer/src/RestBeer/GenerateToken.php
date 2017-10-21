<?php
namespace RestBeer;

use Firebase\JWT\JWT;
use Zend\Stratigility\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class GenerateToken implements MiddlewareInterface
{

    public function __invoke(Request $request, Response $response, callable $out = null)
    {
        $data = $request->getParsedBody();

        if ($this->valid($data)) {
            $objJWT = new \stdClass();
            $objJWT->id = 15;
            $objJWT->nome = "token_webdev";

            $token = JWT::encode($objJWT, "webdev2017");

            $response->getBody()->write($token);

            return $response;
        }

        return $response->withStatus(401, 'Usuário e/ou senha inválido!');

    }

    protected function valid($data) {
        if ($data['username'] == 'user' && $data['password'] == '123') {
            return true;
        }

        return false;
    }

}
