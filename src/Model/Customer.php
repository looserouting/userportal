<?php
declare(strict_types=1);

namespace App\Model;

use PDO;
use DI\Attribute\Inject;

class Customer {
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

  public function fetchAll() :array|bool
  {
     $stmt = $this->dbo->prepare("select * from customers where id = :id");
     $stmt->execute(array('id' => $this->id));

    return $stmt->fetchAll(); 
  }
}
?>
