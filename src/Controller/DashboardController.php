<?php

namespace App\Controller;


class DashboardController extends AbstractController
{
  /**
   * Aufbau der Standardseite. Suche und Auflistung der Produkte
   */
  function show() : void
  {
    echo $this->render('Dashboard/dashboard.html.twig');
  }
}
