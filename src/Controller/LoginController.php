<?php

declare(strict_types=1);

namespace App\Controller;

use App\Model\UserSession;
use DI\Attribute\Inject;

class LoginController extends AbstractController
{
    #[Inject]
    private UserSession $user;

    public function login(): void
    {
        $error = array();

        // if User is already authenticated redirect to
        if ($this->user->isAuthenticated()) {
            $this->redirect('/dashboard');
        }

        // if POST then check formular and authenticate using User->authenticate
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->user->authenticate($_POST['email'], $_POST['password']);
            if ($this->user->isAuthenticated()) {
                $this->redirect('/');
            }
            $error[] = 'Benutzername oder Kennwort falsch!';
        }
        echo $this->render('Login/login.html.twig', ['errors' => $error]);
    }

    public function logout(): void
    {
        session_destroy();
        $this->redirect('/login');
    }
}
