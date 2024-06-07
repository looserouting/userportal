<?php

declare(strict_types=1);

namespace App\Controller;

class ProductsController extends AbstractController
{
    /**
     * Aufbau der Standardseite. Suche und Auflistung der Produkte
     */
    public function list(): void
    {
        echo $this->render('Products/products.html.twig');
    }

    public function add(): void
    {
    }

    public function get(): void
    {
    }

    public function modify(): void
    {
    }

    public function delete(): void
    {
    }
}
