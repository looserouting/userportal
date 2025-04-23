<?php
declare(strict_types=1);

namespace App\Repository;

use App\Model\Customer;
use DI\Attribute\Inject;
use PDO;

class CustomerRepository
{
    #[Inject]
    private PDO $dbo;

    public function fetchAll(): array|bool
    {
            $stmt = $this->dbo->prepare("select * from customers where id = :id");
            $stmt->execute(['id' => $_SESSION['id']]);
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Customer');

            return $stmt->fetchAll();
    }
    
}