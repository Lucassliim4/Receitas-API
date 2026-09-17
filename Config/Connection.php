<?php
namespace Config;

use PDO;
use PDOException;

class Connection {
    private static $instance;

    public static function getConnection() {
        if (!self::$instance) {
            try {
                $host = '127.0.0.1';
                $db   = 'receitas_db';
                $user = 'root';
                $pass = '1234'; 
                self::$instance = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
                self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die(json_encode(['erro' => 'Erro na conexão: ' . $e->getMessage()]));
            }
        }
        return self::$instance;
    }
}