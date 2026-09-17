<?php
namespace Model;

use PDO;

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
        $stmt->execute([':id' => $id]);
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
            ':tempo_preparo_minutos' => $dados['tempo_preparo_minutos'],
            ':categoria'             => $dados['categoria']
        ]);
    }

    // NOVO MÉTODO: Atualizar dados no banco
    public function atualizar($id, $dados) {
        $sql = "UPDATE receitas 
                SET titulo = :titulo, 
                    ingredientes = :ingredientes, 
                    modo_preparo = :modo_preparo, 
                    tempo_preparo_minutos = :tempo_preparo_minutos, 
                    categoria = :categoria 
                WHERE id = :id";
        
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':id'                    => $id,
            ':titulo'                => $dados['titulo'],
            ':ingredientes'          => $dados['ingredientes'],
            ':modo_preparo'          => $dados['modo_preparo'],
            ':tempo_preparo_minutos' => $dados['tempo_preparo_minutos'],
            ':categoria'             => $dados['categoria']
        ]);
    }

    public function deletar($id) {
        $stmt = $this->conn->prepare("DELETE FROM receitas WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }
}