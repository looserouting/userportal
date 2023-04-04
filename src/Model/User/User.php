<?php

namespace App\Model\User;

class User
{
    private $id;
    private $auth;
    private $pdouser;
    private $sessionuser;

    public function __construct(PDOUser $pdouser, SessionUser $sessionuser)
    {
        $this->pdouser = $pdouser;
        $this->sessionuser = $sessionuser;
        $this->auth = 0;
    }

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
