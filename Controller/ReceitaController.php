<?php

namespace Controller;

use Model\ReceitaModel;
use OpenApi\Attributes as OA;

#[OA\Info(
    title: "API de Receitas",
    version: "1.0.0",
    description: "API RESTful para gerenciamento de receitas culinárias"
)]
#[OA\Server(
    url: "http://receitas-api.test",
    description: "Servidor Local"
)]
class ReceitaController
{
    private $model;

    public function __construct()
    {
        $this->model = new ReceitaModel();
    }

    #[OA\Get(
        path: "/receitas",
        summary: "Lista todas as receitas",
        tags: ["Receitas"],
        responses: [
            new OA\Response(
                response: 200, 
                description: "Lista retornada com sucesso",
                content: new OA\JsonContent(type: "array", items: new OA\Items(ref: "#/components/schemas/Receita"))
            ),
            new OA\Response(response: 500, description: "Erro interno do servidor")
        ]
    )]
    public function listar()
    {
        try {
            $receitas = $this->model->listar();
            echo json_encode($receitas);
        } catch (\PDOException $e) {
            http_response_code(500);
            echo json_encode(['mensagem' => 'Erro interno do servidor']);
        }
    }

    #[OA\Get(
        path: "/receitas/{id}",
        summary: "Obtém informações de uma receita",
        tags: ["Receitas"],
        parameters: [
            new OA\Parameter(
                name: "id", 
                in: "path", 
                required: true, 
                description: "ID da receita a ser buscada",
                schema: new OA\Schema(type: "integer", example: 1)
            )
        ],
        responses: [
            new OA\Response(
                response: 200, 
                description: "Receita encontrada",
                content: new OA\JsonContent(ref: "#/components/schemas/Receita")
            ),
            new OA\Response(response: 404, description: "Receita não encontrada")
        ]
    )]
    public function buscarPorId($id)
    {
        try {
            $receita = $this->model->buscarPorId($id);
            if ($receita) {
                echo json_encode($receita);
            } else {
                http_response_code(404);
                echo json_encode(['mensagem' => 'Receita não encontrada']);
            }
        } catch (\PDOException $e) {
            http_response_code(500);
            echo json_encode(['mensagem' => 'Erro interno do servidor']);
        }
    }

    #[OA\Post(
        path: "/receitas",
        summary: "Cadastra uma nova receita",
        tags: ["Receitas"],
        requestBody: new OA\RequestBody(
            required: true,
            description: "Dados para cadastrar uma nova receita",
            content: new OA\JsonContent(ref: "#/components/schemas/Receita")
        ),
        responses: [
            new OA\Response(response: 201, description: "Receita criada com sucesso"),
            new OA\Response(response: 400, description: "Dados inválidos")
        ]
    )]
    public function criar()
    {
        $dados = json_decode(file_get_contents('php://input'), true);

        if (empty($dados['titulo']) || empty($dados['ingredientes']) || empty($dados['modo_preparo'])) {
            http_response_code(400);
            echo json_encode(['mensagem' => 'Dados incompletos']);
            return;
        }

        try {
            $this->model->criar($dados);
            http_response_code(201);
            echo json_encode(['mensagem' => 'Receita cadastrada com sucesso']);
        } catch (\PDOException $e) {
            http_response_code(500);
            echo json_encode(['mensagem' => 'Erro ao cadastrar']);
        }
    }

    #[OA\Put(
        path: "/receitas/{id}",
        summary: "Atualiza uma receita",
        tags: ["Receitas"],
        parameters: [
            new OA\Parameter(
                name: "id", 
                in: "path", 
                required: true, 
                description: "ID da receita a ser atualizada",
                schema: new OA\Schema(type: "integer", example: 1)
            )
        ],
        requestBody: new OA\RequestBody(
            required: true,
            description: "Novos dados para atualização da receita",
            content: new OA\JsonContent(ref: "#/components/schemas/Receita")
        ),
        responses: [
            new OA\Response(response: 200, description: "Receita atualizada com sucesso"),
            new OA\Response(response: 404, description: "Receita não encontrada")
        ]
    )]
    public function atualizar($id)
    {
        $dados = json_decode(file_get_contents('php://input'), true);

        if (empty($dados['titulo']) || empty($dados['ingredientes']) || empty($dados['modo_preparo'])) {
            http_response_code(400);
            echo json_encode(['mensagem' => 'Dados incompletos']);
            return;
        }

        try {
            $sucesso = $this->model->atualizar($id, $dados);
            if ($sucesso) {
                echo json_encode(['mensagem' => 'Receita atualizada com sucesso']);
            } else {
                http_response_code(404);
                echo json_encode(['mensagem' => 'Receita não encontrada']);
            }
        } catch (\PDOException $e) {
            http_response_code(500);
            echo json_encode(['mensagem' => 'Erro ao atualizar']);
        }
    }

    #[OA\Delete(
        path: "/receitas/{id}",
        summary: "Exclui uma receita",
        tags: ["Receitas"],
        parameters: [
            new OA\Parameter(
                name: "id", 
                in: "path", 
                required: true, 
                description: "ID da receita a ser excluída",
                schema: new OA\Schema(type: "integer", example: 1)
            )
        ],
        responses: [
            new OA\Response(response: 200, description: "Receita deletada com sucesso"),
            new OA\Response(response: 404, description: "Receita não encontrada")
        ]
    )]
    public function deletar($id)
    {
        try {
            $sucesso = $this->model->deletar($id);
            if ($sucesso) {
                echo json_encode(['mensagem' => 'Receita deletada com sucesso']);
            } else {
                http_response_code(404);
                echo json_encode(['mensagem' => 'Receita não encontrada']);
            }
        } catch (\PDOException $e) {
            http_response_code(500);
            echo json_encode(['mensagem' => 'Erro ao deletar']);
        }
    }
}