<?php

namespace App\Middleware;

use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
// use Zend\Diactoros\Response\JsonResponse;
use App\Model\Beer;

class Validate implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, DelegateInterface $delegate)
    {
        $beer = new Beer;
        $inputFilter = $beer->getInputFilter();
        $inputFilter->setData($this->parseBody($request));
        if (!$inputFilter->isValid()) {
            $errors = [];
            foreach ($inputFilter->getMessages() as $key => $values) {
                $messages = [];
                foreach ($values as $message) {
                    $messages[] = $message;
                }
                $errors[] = [
                    'input' => $key,
                    'messages' => $messages,
                ];
            }
            throw new \Exception(json_encode($errors), 422);
        }

        return $delegate->process($request);
    }

    private function parseBody($request)
    {
        switch ($request->getMethod()) {
            case 'POST':
                return $request->getParsedBody();
                break;
            case 'PUT':
                parse_str(file_get_contents("php://input"),$data);
                return $data;
                break;
        }

        return [];
    }
}
