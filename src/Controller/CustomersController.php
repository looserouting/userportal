<?php
declare(strict_types=1);

namespace App\Controller;

class CustomersController extends AbstractController
{
    /**
     * Aufbau der Standardseite. Abrechnung Bestellungen und Tickets
     */
    public function list(): void
    {
      echo $this->render('Customers/customers.html.twig');
    }
}
