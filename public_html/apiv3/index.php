<?php
require("../../db_cls.php");
require("mysecrets.php");

require __DIR__ . '/../../vendor/autoload.php';

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

$app = AppFactory::create();
$app->setBasePath('/apiv3');


// Setup HTTP Basic Auth

$app->add(new Tuupola\Middleware\HttpBasicAuthentication([
  "secure" => true,
  "relaxed" => ["127.0.0.1", "localhost", "pontualimportbrindes.com.br", "www.pontualimportbrindes.com.br"],
  "users" => [
      "pontual" => $PONTUAL_PASSWORD_HASH
    ]
  ]));


// Setup CORS
$app->options('/{routes:.+}', function ($request, $response, $args) {
    return $response;
});

$app->add(function ($request, $handler) {
    $response = $handler->handle($request);
    return $response
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
});
    

// Routes (always add trailing / in the browser)

$app->get('/', function (Request $request, Response $response, $args) {
        $response->getBody()->write("hello admin");
    return $response;
});

// List produtos

$app->get('/produtos/', function (Request $request, Response $response, $args) {
  $pdowrapper = new PdoWrapper();
  $dbh = $pdowrapper->getConnection();

  $sth = $dbh->prepare("select codigo, descricao, peso, medidas, preco from v2_produto order by codigo");
  $sth->execute();
  
  $response->getBody()->write(json_encode($sth->fetchAll()));
  
  return $response
      ->withHeader('Access-Control-Allow-Origin', '*')
      ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
      ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS')
      ->withHeader('Content-Type', 'application/json');
});


$app->run();
