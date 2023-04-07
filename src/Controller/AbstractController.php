<?php

namespace App\Controller;

use Twig\Environment;
use DI\Attribute\Inject;


class AbstractController
{
    #[Inject]
    protected Environment $twig;

    protected function render($file)
    {
        return $this->twig->render($file);
    }

    protected function redirect($location)
    {
        header('Location: $location', true, 302);
        exit();
    }
}
