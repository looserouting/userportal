<?php

declare(strict_types=1);

namespace App\Controller;

use App\Model\User;
use DI\Attribute\Inject;

class UsersController extends AbstractController
{
    #[Inject]
    private User $user;

    /**
     * Aufbau der Standardseite. Suche und Auflistung der der Benutzer
     */
    public function list(): void
    {
        echo $this->render('Users/users.html.twig');
    }

    public function add(): void
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];
            $email = $_POST['email'];

            $user = new User();
            $createdUser = $user->create($username, $password, $email);

            if ($createdUser) {
                echo "User erfolgreich erstellt!";
            } else {
                echo "Fehler beim Erstellen des Users.";
            }
        } else {
            echo $this->render('Users/add.html.twig');
        }
    }

    public function fetch(): void
    {
        header('Content-Type: application/json');

        // Parameter von DataTables
        $limit = $_GET['length']; // Anzahl der Datensätze pro Seite
        $offset = $_GET['start']; // Startindex
        $search = $_GET['search']['value']; // Suchbegriff

        // Gesamtanzahl der Datensätze in der Datenbank
        $totalRecords = $user->getTotalRecords();

        // Suchabfrage
        $sql = "SELECT id, username, email, created_at, updated_at FROM users";
        if (!empty($search)) {
            $sql .= " WHERE username LIKE :search OR email LIKE :search";
        }
        $sql .= " LIMIT :limit OFFSET :offset";

        $stmt = $dbo->prepare($sql);
        if (!empty($search)) {
            $stmt->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
        }
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
        $stmt->execute();
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Gesamtanzahl der gefilterten Datensätze
        $totalFiltered = empty($search) ? $totalRecords : $stmt->rowCount();

        echo json_encode([
            'draw' => intval($_GET['draw']),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $totalFiltered,
            'data' => $users
        ]);
    }
}
