<?php

namespace App\Controller;

use App\Model\User\User;

class LoginController extends AbstractController
{
    /**
     * @Inject
     * @var User
     */
    private $user;

    public function login()
    {
        // if User is already authenticated redirect to /
        if ( $this->user->isAuthenticated() )
        {
            $this->redirect('/');
        }

        // if POST then check formular and authenticate using User->authentivate
        if ( $_SERVER['REQUEST_METHOD'] == 'POST')
        {
             if ( $this->user->authenticate($_POST['email'],$_POST['password']) )
             {
                 $this->redirect('/');
             }
        }
        echo $this->render('Login/login.html.twig');
    }
}
