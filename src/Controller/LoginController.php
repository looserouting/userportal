<?php

namespace App\Controller;

use App\Service\LoginService;
use DI\Attribute\Inject;

class LoginController extends AbstractController
{
    #[Inject]
    private LoginService $user;

    public function login()
    {
        // if User is already authenticated redirect to /
        if ( $this->user->isAuthenticated() )
        {
            $this->redirect('/');
        }

        // if POST then check formular and authenticate using User->authenticate
        if ( $_SERVER['REQUEST_METHOD'] == 'POST')
        {
            $this->user->authenticate($_POST['email'],$_POST['password']);
             if ( $this->user->isAuthenticated() )
             {
                 $this->redirect('/');
             }
             //TODO else fehlermeldung ausgeben
        }
        echo $this->render('Login/login.html.twig');
    }
}
