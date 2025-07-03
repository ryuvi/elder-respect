<?php
// Ativa erros para desenvolvimento
require_once __DIR__ . '/config/config.php';

// Autoload manual para carregar classes automaticamente
require_once __DIR__ . '/config/autoloader.php';

// Carrega as rotas definidas
$routes = require __DIR__ . '/config/routes.php';

session_start();

// Captura a URI atual
$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$requestUri = rtrim($requestUri, '/');

// Se estiver na raiz, define como "/"
if ($requestUri === '') {
    $requestUri = '/';
}

// Verifica se a rota existe
if (!array_key_exists($requestUri, $routes)) {
    header("HTTP/1.1 404 Not Found");
    echo "Página não encontrada.";
    exit;
}

// Extrai o controlador e o método
list($controllerName, $method) = $routes[$requestUri];

// Instancia o controlador automaticamente (autoload cuida do include)
try {
    $controller = new $controllerName();
} catch (Exception $e) {
    header("HTTP/1.1 500 Internal Server Error");
    echo "Erro ao carregar o controlador: " . $e->getMessage();
    exit;
}

// Verifica se o método existe
if (!method_exists($controller, $method)) {
    header("HTTP/1.1 500 Internal Server Error");
    echo "<h1>Método '$method' não encontrado em $controllerName.</h1>";
    exit;
}

// Chama o método
$controller->$method();
