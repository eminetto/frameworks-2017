<?php

use Zend\Expressive\AppFactory;

require './src/routes.php';

$loader = require 'vendor/autoload.php';
$loader->add('RestBeer', __DIR__.'/src');

$app = AppFactory::create();
$app->pipe(new RestBeer\Auth());
$app->pipeRoutingMiddleware();
$app->pipeDispatchMiddleware();
$app->pipe(new RestBeer\Format\Json());
$app->pipe(new RestBeer\Format\Html());
$app->run();
