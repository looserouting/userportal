<?php

declare(strict_types=1);

namespace App\Model;

use DI\Attribute\Inject;
use PDO;

class User
{
    #[Inject]
    private PDO $dbo;

    // Function to create a new user
    public function create($username, $password, $email)
    {
        $this->setUsername($username);
        $this->setPassword($password);
        $this->setEmail($email);
        $this->setCreatedAt(date('Y-m-d H:i:s'));
        $this->setUpdatedAt(date('Y-m-d H:i:s'));

        $db->query("INSERT INTO users (username, password, email, created_at, updated_at) VALUES (?, ?, ?, ?, ?)", [
            $this->getUsername(),
            $this->getPassword(),
            $this->getEmail(),
            $this->getCreatedAt(),
            $this->getUpdatedAt()
        ]);

        return $this;
    }

    // Function to update an existing user
    public function update($id, $username, $email)
    {
        $this->setId($id);
        $this->setUsername($username);
        $this->setEmail($email);
        $this->setUpdatedAt(date('Y-m-d H:i:s'));

        $db->query("UPDATE users SET username = ?, email = ?, updated_at = ? WHERE id = ?", [
            $this->getUsername(),
            $this->getEmail(),
            $this->getUpdatedAt(),
            $this->getId()
        ]);

        return $this;
    }

    /**
    * @return array<mixed, bool>
    */
    public function findbycredentials(string $username, string $password): array|bool
    {
        $stmt = $this->dbo->prepare("select * from users where mail = :username and password = :password");
        $stmt->execute(array('username' => $username, 'password' => $password));

        //TODO don't fetch password
        return $stmt->fetchAll();
    }

    public function getTotalRecords() {
        $query = "SELECT COUNT(*) AS total FROM products";
        $result = $this->conn->query($query);
        return $result->fetch_assoc()['total'];
    }

    public function getFilteredRecords($searchValue) {
        $searchQuery = "";
        if (!empty($searchValue)) {
            $searchQuery = "WHERE name LIKE '%$searchValue%' OR position LIKE '%$searchValue%' OR office LIKE '%$searchValue%'";
        }

        $query = "SELECT COUNT(*) AS total FROM products $searchQuery";
        $result = $this->conn->query($query);
        return $result->fetch_assoc()['total'];
    }

    public function getUsers($start, $length, $searchValue, $orderColumn, $orderDir) {
        $searchQuery = "";
        if (!empty($searchValue)) {
            $searchQuery = "WHERE name LIKE '%$searchValue%' OR position LIKE '%$searchValue%' OR office LIKE '%$searchValue%'";
        }

        // Begrenze die Anzahl der gelesenen Zeilen auf $this->maxRows
        $limit = min($this->maxRows, $length);
        $query = "SELECT * FROM products $searchQuery ORDER BY $orderColumn $orderDir LIMIT $start, $limit";
        $result = $this->conn->query($query);

        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }

        return $data;
    }
}
