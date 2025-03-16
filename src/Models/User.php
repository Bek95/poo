<?php

namespace App\Models;

use App\Core\QueryBuilder;

class User {
    private QueryBuilder $query;

    public function __construct() {
        $this->query = new QueryBuilder('users'); // Table "users"
    }

    // Récupérer tous les utilisateurs
    public function getAllUsers(): array {
        return $this->query->select(['id', 'name', 'email'])->get();
    }

    // Récupérer un utilisateur par son ID
    public function getUserById(int $id): array {
        return $this->query->select()->where('id', '=', $id)->get();
    }

    // Ajouter un utilisateur
    public function addUser(string $name, string $email): bool {
        return $this->query->insert([
            'name' => $name,
            'email' => $email
        ]);
    }

    // Mettre à jour un utilisateur
    public function updateUser(int $id, array $data): bool {
        return $this->query->where('id', '=', $id)->update($data);
    }

    // Supprimer un utilisateur
    public function deleteUser(int $id): bool {
        return $this->query->where('id', '=', $id)->delete();
    }
}
