<?php

namespace App\Model\User;

use App\Model\User\PDOUser;
use DI\Attribute\Inject;

class User
{
    private $id;
    private $auth = 0;

    #[Inject]
    private PDOUser $pdouser;

    #[Inject]
    private SessionUser $sessionuser;

    public function register()
    {

    }

    public function authenticate($username, $password)
    {
        // authenticate user through database
        $this->sessionuser->setAuthentication($this->pdouser->authenticate($username, $password));
        return $this->sessionuser->auth;
    }

    public function isAuthenticated()
    {
        if ($this->auth > 0)
            return true;
        else
            return false;
    }

    public function setPassword($password)
    {

    }
}
