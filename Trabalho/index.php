<?php
use Zend\Expressive\AppFactory;

$loader = require 'vendor/autoload.php';
$loader->add('Autenticacao', __DIR__.'/src');

$app = AppFactory::create();

$app->pipeRoutingMiddleware();
$app->pipeDispatchMiddleware();

$app->pipe(new Autenticacao\Format\Json());
$app->pipe(new Autenticacao\Format\Html());

$app->get('/',new RestBeer\Brands());
$app->get('/styles', new RestBeer\Styles());
$app->get('/beer/{id}', new RestBeer\Beer());
$app->post('/beer', new RestBeer\Beer());
$app->post('/beer/', new RestBeer\BeerPost());
$app->put('/beer/{id}', new RestBeer\BeerPost());
$app->run();
