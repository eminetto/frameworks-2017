<?php
use Zend\Expressive\AppFactory;

require 'vendor/autoload.php';

$app = AppFactory::create();

$app->get('/', function ($request, $response, $next) {
    $response->getBody()->write('Hello, world!');
    return $response;
});

$beers = [
    'brands' => ['Heineken', 'Guinness', 'Skol', 'Colorado'],
    'styles' => ['Pilsen' , 'Stout']
];

$app->get('/brands', function ($request, $response, $next) use ($beers) {
    $response->getBody()->write(implode(',', $beers['brands']));
    return $response;
});

$app->get('/styles', function ($request, $response, $next) use ($beers) {
    $response->getBody()->write(implode(',', $beers['styles']));
    return $response;
});


$app->pipeRoutingMiddleware();
$app->pipeDispatchMiddleware();
$app->run();
