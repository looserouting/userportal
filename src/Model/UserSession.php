<?php

declare(strict_types=1);

namespace App\Model;

use DI\Attribute\Inject;
use App\Repository\UserRepository;

class UserSession
{
    #[Inject]
    private UserRepository $user;
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
            $_SESSION['sessionuser'][$key] = $value;
        }

    }
    public function register(): void
    {

    }

    public function authenticate(string $username, string $password): void
    {
        if($userdata = $this->user->findbycredentials($username, $password)) {
            $this->save($userdata);
            $this->save(['auth' => true]);
        }else {
            // Handle authentication failure
            $this->save(['auth' => false]);
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
