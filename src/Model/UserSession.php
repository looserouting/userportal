<?php

declare(strict_types=1);

namespace App\Model;

use DI\Attribute\Inject;
use App\Model\User;

class UserSession
{
    #[Inject]
    private User $pdouser;

    public function get(string $param): mixed
    {
        if (isset($_SESSION['sessionuser'][$param])) {
            return $_SESSION['sessionuser'][$param];
        }
        return false;
    }

    /* Save User into $_SESSION */
    /**
      * @param array<int|string> $data Array with session parameters
    */
    public function save(array $data): void
    {
        foreach($data as $key => $value) {
            print_r($data);
            $_SESSION['sessionuser'][$key] = $value;
        }

    }
    public function register(): void
    {

    }

    public function authenticate(string $username, string $password): void
    {
        // search for user in database
        if($userdata = $this->pdouser->findbycredentials($username, $password)) {
            $this->save($userdata);
            $this->save(['auth' => true]);
        }
    }

    public function isAuthenticated(): bool
    {
        if($this->get('auth')) {
            return true;
        }
        return false;
    }
}
