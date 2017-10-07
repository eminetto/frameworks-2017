<?php

namespace App\Middleware;

use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use App\Model\Beer;

class Validate implements MiddlewareInterface
{
    private $config;

    public function __construct($config)
    {
        $this->config = $config;
    }

    public function process(ServerRequestInterface $request, DelegateInterface $delegate)
    {
        if (empty($this->config)) {
            return $delegate->process($request);
        }
        $uri = $request->getUri()->getPath();
        $uri = explode('/', $uri)[1];

        $method = $request->getMethod();
        $class = null;
        foreach ($this->config as $c) {
            if ($c['uri'] != $uri) {
                continue;
            }
            if (!in_array($method, $c['method'])) {
                continue;
            }
            $class = $c['class'];
        }
        if (!$class) {
            return $delegate->process($request);
        }
        $entity = new $class;
        $inputFilter = $entity->getInputFilter();
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
                parse_str(file_get_contents("php://input"), $data);
                return $data;
                break;
        }

        return [];
    }
}
