<?php
use Zend\Expressive\AppFactory;

$loader = require 'vendor/autoload.php';
$loader->add('RestBeer', __DIR__.'/src');

$app = AppFactory::create();

//$app->pipe(new RestBeer\Auth());
$app->pipeRoutingMiddleware();
// $app->pipe(new Coderockr\Middleware\FileUpload());
$app->pipeDispatchMiddleware();
$app->pipe(new RestBeer\Format\Json());
$app->pipe(new RestBeer\Format\Html());
// $app->pipe(new RestBeer\Format\Xml());
$app->get('/brands',new RestBeer\Brands());
$app->get('/styles', new RestBeer\Styles());
$app->get('/beer/{id}', new RestBeer\Beer());
$app->post('/beer', new RestBeer\Beer());
$app->post('/beer/', new RestBeer\BeerPost());
$app->put('/beer/{id}', new RestBeer\BeerPost());
$app->run();
