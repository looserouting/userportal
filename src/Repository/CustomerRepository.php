<?php
declare(strict_types=1);

namespace App\Repository;

use App\Model\Customer;

class CustomerRepository
{
    public function fetchAll(): array|bool
    {
            $stmt = $this->dbo->prepare("select * from customers where id = :id");
            $stmt->execute(['id' => $this->id]);
            $statement->setFetchMode(PDO::FETCH_CLASS, 'Customer');

            return $stmt->fetchAll();
    }
    
}