<?php

namespace App\Service;

use App\Model\PDOUser;
use App\Model\SessionUser;
use DI\Attribute\Inject;

class LoginService
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
        // search for user in database
        if( $userdata = $this->pdouser->get($username, $password) )
        {
            $this->sessionuser->save($userdata);
            $this->auth=1;
        }
        $this->auth=0;
    }

    public function isAuthenticated()
    {
        if( $this->auth == 1 )
            return true;
        return false;
    }
}