<?php

declare(strict_types=1);

namespace App\Model;

use PDO;
use DI\Attribute\Inject;

class Customer
{
    #[Inject]
    private PDO $dbo;
    private $id;
    /**
     * @param mixed $id
     */
    private function __construct($id)
    {
        $this->id = $id;
    }
}
