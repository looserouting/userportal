<?php
declare(strict_types=1);

namespace App\Controller;

class PBXController extends AbstractController
{
    /**
     * Aufbau der Standardseite. Suche und Auflistung der Produkte
     */
    public function show(): void
    {
        echo $this->render('PBX/pbx.html.twig');
    }
}
