<?php

require_once(__DIR__ . "/../config/PDO.conf.php");

use App\Model\User;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Psr\Container\ContainerInterface;


return [
    'db.dns'    => PDO_DNS,
    'db.user'   => PDO_USER,
    'db.passwd' => PDO_PASSWD,
    'db.options'=> PDO_OPTIONS,

    PDO::class => DI\factory(function(ContainerInterface $c) {
      return new PDO($c->get('db.dns'), $c->get('db.user'), $c->get('db.passwd'), $c->get('db.options'));
    }),

    //Configure twig
    Environment::class => DI\factory(function () {
        $loader = new FilesystemLoader(__DIR__ . '/../src/View');
        return new Environment($loader);
    })

];
