<?php

namespace RestBeer\Format;

use Zend\Stratigility\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Zend\Expressive\Twig\TwigRenderer;
use Zend\Diactoros\Response\HtmlResponse;

class Html implements MiddlewareInterface
{
    public function __invoke(Request $request, Response $response, callable $out = null)
    {
        $content = unserialize($response->getBody());
        $header = $request->getHeader('accept');
        $accept = null;
        if (isset($header[0])) {
            $accept = $header[0];
        }
        if ($accept != 'text/html' ) {
            return $out($request, $response);
        }
        $twig = new TwigRenderer();
        $twig->addPath('views');
        $html = $twig->render('content.twig', ['content' => $content]);
        return new HtmlResponse($html);
    }
}
