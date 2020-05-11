<?php
require("../../db_cls.php");
require("adminsecrets.php");

require __DIR__ . '/../../vendor/autoload.php';

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

$app = AppFactory::create();
$app->setBasePath('/adminapi');


// Setup HTTP Basic Auth

$app->add(new Tuupola\Middleware\HttpBasicAuthentication([
    "secure" => true,
    "relaxed" => ["127.0.0.1", "localhost", "pontualimportbrindes.com.br", "www.pontualimportbrindes.com.br"],
    "users" => [
        "pontual" => $PONTUAL_PASSWORD_HASH
    ]
]));

// Parse JSON
$app->addBodyParsingMiddleware();
$app->addRoutingMiddleware();
$app->addErrorMiddleware(true, true, true);

// Setup CORS
$app->options('/{routes:.+}', function ($request, $response, $args) {
    return $response;
});

$app->add(function ($request, $handler) {
    $response = $handler->handle($request);
    return $response
        ->withHeader('Access-Control-Allow-Origin', '*')
        ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
        ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS')
        ->withHeader('Content-Type', 'application/json');
});

// Routes (always add trailing / in the browser)

$app->post('/categorias/add/', function (Request $request, Response $response, $args) {
    $dbh = getdbh();
    
    $data = $request->getParsedBody();
    $nome = $data['nome'];

    $sql = "insert into v3_categoriadeproduto (nome, publico) values (:nome, 1)";
    $sth = $dbh->prepare($sql);

    /*
    try {
        $sth->execute([':nome' => $nome]);
    } catch(PDOException $exception) {
        $response->getBody()->write($exception->getMessage());
        return $response;
    }
    */
    $response->getBody()->write("Added categoriadeproduto $nome");
    return $response;
});

// List produtos

$app->get('/produtos/', function (Request $request, Response $response, $args) {
    $pdowrapper = new PdoWrapper();
    $dbh = $pdowrapper->getConnection();

    $sth = $dbh->prepare("select codigo, descricao, peso, medidas, preco from v2_produto order by codigo");
    $sth->execute();
    
    $response->getBody()->write(json_encode($sth->fetchAll()));
    
    return $response;
});


$app->run();
