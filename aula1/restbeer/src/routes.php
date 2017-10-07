<?php

$db = new \PDO('sqlite:beers.db');

//managing the application routes

$app->get('/', new \RestBeer\Http\Home());
$app->post('/login', new \RestBeer\GenerateToken());
$app->get('/brands', new \RestBeer\Http\NewBrand());
$app->get('/styles', new \RestBeer\Http\Styles());
$app->post('/beer', new \RestBeer\Http\NewBeer($db));
$app->get('/beer/{id}', new \RestBeer\Http\Beer());
$app->put('/beer/{id}', new \RestBeer\Http\UpdateBeer($db));