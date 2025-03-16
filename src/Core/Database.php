<?php

namespace App\Core;

class Database
{
    private static ?Database $instance = null;
    private ?\PDO $connection = null;

    private function __construct()
    {
        try {
            $dsn = "mysql:host=localhost;dbname=testdb;charset=utf8mb4";
            $username = "root";
            $password = "";
            $options = [
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
                \PDO::ATTR_EMULATE_PREPARES => false,
            ];

            $this->connection = new \PDO($dsn, $username, $password, $options);
            echo "✅ Connexion à la base de données établie !\n";
        } catch (\PDOException $e) {
            die("❌ Erreur de connexion : " . $e->getMessage());
        }
    }

    // Empêcher le clonage et la désérialisation
    private function __clone()
    {
    }

    private function __wakeup()
    {
    }

    // Méthode pour récupérer l’instance unique
    public static function getInstance(): Database
    {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    // Retourne la connexion PDO
    public function getConnection(): \PDO
    {
        return $this->connection;
    }
}

