<?php

declare(strict_types=1);

namespace App\Controller;

class TicketsController extends AbstractController
{
    /**
     * Aufbau der Standardseite. Suche und Auflistung der Bestellungen
     */
    public function list(): void
    {
        echo $this->render('Tickets/tickets.html.twig');
    }
}
