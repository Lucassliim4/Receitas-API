<?php
namespace Model;

use Config\Connection;
use PDO;
use PDOException;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: "Receita",
    type: "object",
    title: "Receita",
    description: "Modelo de dados da Receita",
    required: ["titulo", "ingredientes", "modo_preparo"],
    properties: [
        new OA\Property(property: "id", type: "integer", example: 1, description: "ID único da receita"),
        new OA\Property(property: "titulo", type: "string", example: "Bolo de Cenoura", description: "Título da receita"),
        new OA\Property(property: "ingredientes", type: "string", example: "Cenoura, açúcar, ovos, farinha", description: "Lista de ingredientes"),
        new OA\Property(property: "modo_preparo", type: "string", example: "Bata tudo no liquidificador e asse por 40 min", description: "Modo de preparo"),
        new OA\Property(property: "tempo_preparo_minutos", type: "integer", example: 45, nullable: true, description: "Tempo de preparo em minutos"),
        new OA\Property(property: "categoria", type: "string", example: "Sobremesa", nullable: true, description: "Categoria da receita")
    ]
)]
class ReceitaModel {
    private $conn;

    public function __construct() {
        $this->conn = Connection::getConnection();
    }

    public function listar() {
        $stmt = $this->conn->query("SELECT * FROM receitas ORDER BY created_at DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscarPorId($id) {
        $stmt = $this->conn->prepare("SELECT * FROM receitas WHERE id = :id");
        $stmt->bindValue(':id', (int) $id, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function criar($dados) {
        $sql = "INSERT INTO receitas (titulo, ingredientes, modo_preparo, tempo_preparo_minutos, categoria) 
                VALUES (:titulo, :ingredientes, :modo_preparo, :tempo_preparo_minutos, :categoria)";
        
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':titulo'                => $dados['titulo'],
            ':ingredientes'          => $dados['ingredientes'],
            ':modo_preparo'          => $dados['modo_preparo'],
            ':tempo_preparo_minutos' => $dados['tempo_preparo_minutos'] ?? null,
            ':categoria'             => $dados['categoria'] ?? null
        ]);
    }

    public function atualizar($id, $dados) {
        $sql = "UPDATE receitas 
                SET titulo = :titulo, 
                    ingredientes = :ingredientes, 
                    modo_preparo = :modo_preparo, 
                    tempo_preparo_minutos = :tempo_preparo_minutos, 
                    categoria = :categoria 
                WHERE id = :id";
        
        $stmt = $this->conn->prepare($sql);
        
        $stmt->bindValue(':id', (int) $id, PDO::PARAM_INT);
        $stmt->bindValue(':titulo', $dados['titulo']);
        $stmt->bindValue(':ingredientes', $dados['ingredientes']);
        $stmt->bindValue(':modo_preparo', $dados['modo_preparo']);
        $stmt->bindValue(':tempo_preparo_minutos', $dados['tempo_preparo_minutos'] ?? null);
        $stmt->bindValue(':categoria', $dados['categoria'] ?? null);

        return $stmt->execute();
    }

    public function deletar($id) {
        $stmt = $this->conn->prepare("DELETE FROM receitas WHERE id = :id");
        $stmt->bindValue(':id', (int) $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}