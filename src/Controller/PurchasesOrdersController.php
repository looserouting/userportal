<?php

declare(strict_types=1);

namespace App\Controller;

// TODO
// Bestellung eingeben
// Bestlleingang buchen / gegebenenfalls In Lager oder inventar aufnehmen mit Lieferschein
// Rechnung hinzufügen

class PurchasesOrdersController extends AbstractController
{
    /**
     * Aufbau der Standardseite. Suche und Auflistung der Bestellungen
     */
    public function list(): void
    {
        echo $this->render('Orders/orders.html.twig');
    }
}
