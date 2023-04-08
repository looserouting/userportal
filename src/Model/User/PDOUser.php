<?php

namespace App\Model\User;

use PDO;
use DI\Attribute\Inject;

class PDOUser
{
  #[Inject]
  private PDO $dbo;

  public function authenticate($username, $password)
	{
		$stmt = $this->dbo->prepare("select * from users where email = :username and password = :password");

        $stmt->execute(array('username' => $username, 'password' => $password));

		if ( $stmt->rowCount() == 1 )
			return true;
		else
			return false; // return result ??
	}

  public function save()
    {

    }
}
