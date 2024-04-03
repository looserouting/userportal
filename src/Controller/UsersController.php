<?php
declare(strict_types=1);

namespace App\Controller;

class UsersController extends AbstractController
{
    /**
     * Aufbau der Standardseite. Suche und Auflistung der der Benutzer
     */
    public function list(): void
    {
      echo $this->render('Users/users.html.twig');
    }
}
