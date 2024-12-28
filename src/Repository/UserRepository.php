<?php

namespace App\Repository;

use DI\Attribute\Inject;
use PDO;

class UserRepository {

    #[Inject]
    private PDO $dbo;

    /**
    * @return array<mixed, bool>
    */
    public function findByCredentials(string $username, string $password): array|bool
    {
        $stmt = $this->dbo->prepare("select * from users where mail = :username and password = :password");
        $stmt->execute(array('username' => $username, 'password' => $password));

        //TODO don't fetch password
        return $stmt->fetchAll();
    }
    public function getUsers($start, $length, $searchValue, $orderColumn, $orderDir) {
        $searchQuery = "";
        if (!empty($searchValue)) {
            $searchQuery = "WHERE name LIKE '%$searchValue%' OR position LIKE '%$searchValue%' OR office LIKE '%$searchValue%'";
        }

        // Begrenze die Anzahl der gelesenen Zeilen auf $this->maxRows
        $limit = min(100, $length);
        $query = "SELECT * FROM users $searchQuery ORDER BY $orderColumn $orderDir LIMIT $start, $limit";
        $result = $this->dbo->query($query);

        $data = [];
        while ($row = $result->fetchAll(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }

        return $data;
    }
    public function getTotalRecords() {
        $query = "SELECT COUNT(*) AS total FROM users";
        $result = $this->dbo->query($query);
        return (int)$result->fetch(PDO::FETCH_ASSOC)['total'];
    }

    public function getFilteredRecords($searchValue) {
        $searchQuery = "";
        if (!empty($searchValue)) {
            $searchQuery = "WHERE name LIKE '%$searchValue%' OR position LIKE '%$searchValue%' OR office LIKE '%$searchValue%'";
        }

        $query = "SELECT COUNT(*) AS total FROM users $searchQuery";
        $result = $this->dbo->query($query);

        return $result->fetch_assoc()['total'];
    }
}