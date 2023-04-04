<?php

namespace App\Controller;

use Twig\Environment;

class AbstractController
{
    /**
     * @Inject
     * @var Environment
     */
    protected $twig;

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
