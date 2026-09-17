<?php
namespace Controller;

use Model\ReceitaModel;

class ReceitaController {
    private $model;

    public function __construct() {
        $this->model = new ReceitaModel();
    }

    public function listar() {
        $receitas = $this->model->listar();
        header('Content-Type: application/json');
        echo json_encode($receitas);
    }

    public function buscarPorId($id) {
        header('Content-Type: application/json');
        $receita = $this->model->buscarPorId($id);

        if ($receita) {
            echo json_encode($receita);
        } else {
            http_response_code(404);
            echo json_encode(['mensagem' => 'Receita não encontrada']);
        }
    }

    public function criar() {
        $dados = json_decode(file_get_contents('php://input'), true);

        if (empty($dados['titulo']) || empty($dados['ingredientes']) || empty($dados['modo_preparo'])) {
            http_response_code(400);
            echo json_encode(['mensagem' => 'Dados incompletos']);
            return;
        }

        $sucesso = $this->model->criar($dados);

        if ($sucesso) {
            http_response_code(201);
            echo json_encode(['mensagem' => 'Receita cadastrada com sucesso!']);
        } else {
            http_response_code(500);
            echo json_encode(['mensagem' => 'Erro ao cadastrar receita']);
        }
    }

    // NOVO MÉTODO: Processar edição
    public function atualizar($id) {
        header('Content-Type: application/json');

        $receita = $this->model->buscarPorId($id);
        if (!$receita) {
            http_response_code(404);
            echo json_encode(['mensagem' => 'Receita não encontrada para atualização']);
            return;
        }

        $dados = json_decode(file_get_contents('php://input'), true);

        if (empty($dados['titulo']) || empty($dados['ingredientes']) || empty($dados['modo_preparo'])) {
            http_response_code(400);
            echo json_encode(['mensagem' => 'Dados incompletos para atualização']);
            return;
        }

        $sucesso = $this->model->atualizar($id, $dados);

        if ($sucesso) {
            echo json_encode(['mensagem' => 'Receita atualizada com sucesso!']);
        } else {
            http_response_code(500);
            echo json_encode(['mensagem' => 'Erro ao atualizar receita']);
        }
    }

    public function deletar($id) {
        header('Content-Type: application/json');
        
        $receita = $this->model->buscarPorId($id);
        if (!$receita) {
            http_response_code(404);
            echo json_encode(['mensagem' => 'Receita não encontrada para exclusão']);
            return;
        }

        $sucesso = $this->model->deletar($id);

        if ($sucesso) {
            echo json_encode(['mensagem' => 'Receita deletada com sucesso!']);
        } else {
            http_response_code(500);
            echo json_encode(['mensagem' => 'Erro ao deletar receita']);
        }
    }
}