<?php

namespace App\Controller;

use Twig\Environment;
use DI\Attribute\Inject;

class AbstractController
{
    #[Inject]
    protected Environment $twig;

    protected function render(string $file,mixed $vars=null) : string
    {
        return $this->twig->render($file, array(
            'session'   => $_SESSION,
            'post'      => $_POST,
            'get'       => $_GET,
            'server'    => $_SERVER
        ));
    }

    protected function redirect(string $location) : void
    {
        header('Location: '.$location, true, 302);
        exit();
    }

}
