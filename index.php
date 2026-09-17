<?php

spl_autoload_register(function ($class) {
    $file = __DIR__ . '/' . str_replace('\\', '/', $class) . '.php';
    if (file_exists($file)) {
        require_once $file;
    }
});

use Controller\ReceitaController;

$controller = new ReceitaController();
$method = $_SERVER['REQUEST_METHOD'];
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$segments = explode('/', trim($path, '/'));

if (isset($segments[0]) && $segments[0] === 'receitas') {
    $id = $segments[1] ?? null;

    if ($method === 'GET') {
        if ($id) {
            $controller->buscarPorId($id);
        } else {
            $controller->listar();
        }
    } elseif ($method === 'POST') {
        $controller->criar();
    } elseif ($method === 'PUT') {
        if ($id) {
            $controller->atualizar($id);
        } else {
            http_response_code(400);
            echo json_encode(['mensagem' => 'ID não informado']);
        }
    } elseif ($method === 'DELETE') {
        if ($id) {
            $controller->deletar($id);
        } else {
            http_response_code(400);
            echo json_encode(['mensagem' => 'ID não informado']);
        }
    } else {
        http_response_code(405);
        echo json_encode(['mensagem' => 'Método não permitido']);
    }
} else {
    http_response_code(404);
    echo json_encode(['mensagem' => 'Rota não encontrada']);
}