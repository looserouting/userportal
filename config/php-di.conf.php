<?php

require_once(__DIR__ . "/../config/PDO.conf.php");

//use function DI\create;
use App\Model\User;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;


return [
    'db.dns'    => PDO_DNS,
    'db.user'   => PDO_USER,
    'db.passwd' => PDO_PASSWD,
    'db.options'=> PDO_OPTIONS,

    PDO::class => DI\create()
            ->constructor(DI\get('db.dns'), DI\get('db.user'), DI\get('db.passwd'), DI\get('db.options')),

    // Bind interface to an implementation
    // ProductsRepository::class => create(PDOProductsRepository),

    //Configure twig
    Environment::class => DI\factory(function () {
        $loader = new FilesystemLoader(__DIR__ . '/../src/View');
        return new Environment($loader);
    })

];
