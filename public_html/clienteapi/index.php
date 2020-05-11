<?php
require("../../db_cls.php");
require __DIR__ . '/../../vendor/autoload.php';

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

// allow everyone to access

$app = AppFactory::create();
$app->setBasePath('/clienteapi');

// Setup CORS
$app->options('/{routes:.+}', function ($request, $response, $args) {
    return $response;
});

// Add CORS headers
$app->add(function ($request, $handler) {
    $response = $handler->handle($request);
    return $response
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS')
            ->withHeader('Content-Type', 'application/json'); 
});


// Routes (always add trailing / in the browser)

// produtos list
$app->get('/produtos/', function (Request $request, Response $response, $args) {
    $pdowrapper = new PdoWrapper();
    $dbh = $pdowrapper->getConnection();

    $sth = $dbh->prepare("select codigo, nome, detalhes, cv from v3_produto order by codigo");
    $sth->execute();
    
    $response->getBody()->write(json_encode($sth->fetchAll()));
    
    return $response;
});

// Menu list

$app->get('/menu/', function (Request $request, Response $response, $args) {
    $dbh = getdbh();

    $sth = $dbh->prepare("select id, nome from v3_categoriadeproduto where inativo = 0 order by nome");
    $sth->execute();
    
    $response->getBody()->write(json_encode($sth->fetchAll()));
    return $response;
});


// Produtos da categoria com id especifico

$app->get('/categorias/{id}/', function (Request $request, Response $response, $args) {
    $dbh = getdbh();

    $sth = $dbh->prepare("select codigo, nome, normalizado, sufixo_jpg, medidas, cv, disponivel_ptl, reservado_ptl, disponivel_uni, reservado_uni from v3_produto as p inner join v3_produto_categoria as pc on p.id = pc.produto_id and p.inativo = 0 order by codigo");
    $sth->execute([':id' => $args['id']]);

    $response->getBody()->write(json_encode($sth->fetchAll()));
    return $response;
});

$app->run();
