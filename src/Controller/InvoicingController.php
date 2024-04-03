<?php
declare(strict_types=1);

namespace App\Controller;

class InvoicingController extends AbstractController
{
    /**
     * Aufbau der Standardseite. Abrechnung Bestellungen und Tickets
     */
    public function show(): void
    {
      echo $this->render('Invoicing/invoicing.html.twig');
    }
}
