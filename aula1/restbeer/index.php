<?php
use Zend\Expressive\AppFactory;

$loader = require 'vendor/autoload.php';
$loader->add('RestBeer', __DIR__.'/src');

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
    // $response->getBody()->write(serialize($beers['brands']));
    $response->getBody()->write(implode(',', $beers['brands']));
    // return $response;
    return $next($request, $response);
});

$app->get('/styles', function ($request, $response, $next) use ($beers) {
    $response->getBody()->write(implode(',', $beers['styles']));
    return $response;
});

$app->get('/beer/{id}', function ($request, $response, $next) use ($beers) {
    $id = $request->getAttribute('id');
    if (!isset($beers['brands'][$id])) {
        return $response->withStatus(404);
    }

    $response->getBody()->write($beers['brands'][$id]);

    return $response;
});

$db = new PDO('sqlite:beers.db');
$app->post('/beer', function ($request, $response, $next) use ($db) {
    $db->exec(
        "create table if not exists 
beer (id INTEGER PRIMARY KEY AUTOINCREMENT, name text not null, style text not null)"
    );

    $data = $request->getParsedBody();
    //@TODO: clean form data before insert into the database ;)
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
});

$app->put('/beer/{id}', function ($request, $response, $next) use ($db) {
    $id = $request->getAttribute('id');

    parse_str(file_get_contents("php://input"),$data);
    $stmt = $db->prepare('update beer set name=:name, style=:style where id=:id');
    $stmt->bindParam(':name',$data['name']);
    $stmt->bindParam(':style', $data['style']);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    return $response->withStatus(204);
});

$app->pipe(new RestBeer\Auth());
$app->pipeRoutingMiddleware();
// $app->pipe(new Coderockr\Middleware\FileUpload());
$app->pipeDispatchMiddleware();
$app->pipe(new RestBeer\Format\Json());
$app->pipe(new RestBeer\Format\Html());
// $app->pipe(new RestBeer\Format\Xml());
$app->run();
