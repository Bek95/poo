<?php

namespace App\Core;

use PDO;
use PDOException;

class QueryBuilder {
    private PDO $db;
    private string $table;
    private array $columns = ['*'];
    private array $where = [];
    private array $bindings = [];

    public function __construct(string $table) {
        $this->db = Database::getInstance()->getConnection();
        $this->table = $table;
    }

    // Sélectionner des colonnes spécifiques
    public function select(array $columns = ['*']): self {
        $this->columns = $columns;
        return $this;
    }

    // Ajouter des conditions WHERE
    public function where(string $column, string $operator, mixed $value): self {
        $this->where[] = "$column $operator ?";
        $this->bindings[] = $value;
        return $this;
    }

    // Exécuter la requête et récupérer les résultats
    public function get(): array {
        $sql = "SELECT " . implode(", ", $this->columns) . " FROM {$this->table}";

        if (!empty($this->where)) {
            $sql .= " WHERE " . implode(" AND ", $this->where);
        }

        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute($this->bindings);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            die("❌ Erreur SQL : " . $e->getMessage());
        }
    }

    // Insérer une nouvelle ligne
    public function insert(array $data): bool {
        $columns = implode(", ", array_keys($data));
        $placeholders = implode(", ", array_fill(0, count($data), "?"));
        $values = array_values($data);

        $sql = "INSERT INTO {$this->table} ($columns) VALUES ($placeholders)";

        try {
            $stmt = $this->db->prepare($sql);
            return $stmt->execute($values);
        } catch (PDOException $e) {
            die("❌ Erreur d'insertion : " . $e->getMessage());
        }
    }

    // Mettre à jour une ligne
    public function update(array $data): bool {
        if (empty($this->where)) {
            die("❌ Erreur : WHERE obligatoire pour un UPDATE.");
        }

        $sets = [];
        $values = array_values($data);
        foreach (array_keys($data) as $column) {
            $sets[] = "$column = ?";
        }

        $sql = "UPDATE {$this->table} SET " . implode(", ", $sets) . " WHERE " . implode(" AND ", $this->where);

        try {
            $stmt = $this->db->prepare($sql);
            return $stmt->execute(array_merge($values, $this->bindings));
        } catch (PDOException $e) {
            die("❌ Erreur de mise à jour : " . $e->getMessage());
        }
    }

    // Supprimer une ligne
    public function delete(): bool {
        if (empty($this->where)) {
            die("❌ Erreur : WHERE obligatoire pour un DELETE.");
        }

        $sql = "DELETE FROM {$this->table} WHERE " . implode(" AND ", $this->where);

        try {
            $stmt = $this->db->prepare($sql);
            return $stmt->execute($this->bindings);
        } catch (PDOException $e) {
            die("❌ Erreur de suppression : " . $e->getMessage());
        }
    }
}
