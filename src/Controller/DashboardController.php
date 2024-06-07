<?php

declare(strict_types=1);

namespace App\Controller;

class DashboardController extends AbstractController
{
    /**
     * Aufbau der Standardseite. Suche und Auflistung der Produkte
     */
    public function show(): void
    {
        echo $this->render('Dashboard/dashboard.html.twig');
    }
}
