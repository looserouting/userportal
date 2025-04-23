<?php

declare(strict_types=1);

namespace App\Model;

use DI\Attribute\Inject;
use PDO;

class User
{
    #[Inject]
    private PDO $dbo;

    public int $id;
    public string $username;
    public string $mail;
    private string $password;

    function __construct(string $username, string $password, string $email) {
        $this->mail = $email;
        $this->password = $password;
        $this->username = $username;
    }

    // Function to create a new user
    public function save(): bool
    {
        return $this->dbo->query(
            "INSERT INTO users (mail, password) VALUES (?, ?)", 
            [$this->mail, $this->password]
        );
    }

    // Function to update an existing user
    public function update($id, $username, $email)
    {
        $this->mail = $email;

        $this->dbo->query("UPDATE users SET mail = ?, updated_at = ? WHERE id = ?", [
            $this->mail,
            $this->id
        ]);

        return $this;
    }

}