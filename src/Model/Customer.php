<?php
declare(strict_types=1);

namespace App\Model;

use PDO;
use DI\Attribute\Inject;

class Customer {
    #[Inject]
    private PDO $dbo;

}
?>
