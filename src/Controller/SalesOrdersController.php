<?php

declare(strict_types=1);

namespace App\Controller;

class SalesOrdersController extends AbstractController
{
    /**
     * Aufbau der Standardseite. Suche und Auflistung der Bestellungen
     */
    public function list(): void
    {
        echo $this->render('SalesOrders/salesorders.html.twig');
    }
}
