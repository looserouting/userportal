<?php

namespace App\Controller;


class ProductsController extends AbstractController
{
  /**
   * Aufbau der Standardseite. Suche und Auflistung der Produkte
   */
  function list() : void
  {
    echo $this->render('Products/products.html.twig');
  }

  function add() : void
  {
  }

  function get() : void
  {
  }
  
  function modify() : void
  {
  }

  function delete() : void
  {
  }
}
