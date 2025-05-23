<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\UserRepository;
use App\Model\User;
use PDO;
use DI\Attribute\Inject;


class UsersController extends AbstractController
{
    #[Inject]
    private PDO $dbo;

    #[Inject]
    private UserRepository $userRepository;

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

            $newUser = new User($username, $password, $email);
            
            if ($newUser->save()) {
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
        //TODO get Data from the Repository
        header('Content-Type: application/json');

        // Parameter von DataTables
        $limit = $_POST['length']; // Anzahl der Datensätze pro Seite
        $offset = $_POST['start']; // Startindex
        $search = $_POST['search']['value']; // Suchbegriff

        // Gesamtanzahl der Datensätze in der Datenbank
        // Muss ich das Repository injecten? es hat doch nur standardwerte?
        $totalRecords = $this->userRepository->getTotalRecords();

        // Suchabfrage
        $sql = "SELECT id, mail FROM users";
        if (!empty($search)) {
            $sql .= " WHERE mail LIKE :search";
        }
        $sql .= " LIMIT :limit OFFSET :offset";

        $stmt = $this->dbo->prepare($sql);
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
            'draw' => intval($_POST['draw']),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $totalFiltered,
            'data' => $users
        ]);
    }
}
