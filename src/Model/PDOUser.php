<?php

namespace App\Model;

use DI\Attribute\Inject;
use PDO;

class PDOUser
{
  #[Inject]
  private PDO $dbo;

  public function get($username, $password)
	{
		$stmt = $this->dbo->prepare("select * from users where mail = :username and password = :password");
    $stmt->execute(array('username' => $username, 'password' => $password));
    
    return $stmt->fetchAll();
	}

  public function save()
    {

    }
}
