<?php

namespace App\Model\User;
use PDO;

class PDOUser
{
    private $dbo;

    public function __construct(PDO $dbo)
    {
        $this->dbo = $dbo;
    }

	public function authenticate($username, $password)
	{
		$stmt = $dbo->prepare("select * from user where user = :username and password = :password");

        $stmt->execute(array('username' => $username, 'password' => $password));

		if ( $stmt->rowCount() = 1 )
			return true;
		else
			return false; // return result ??
	}

    public function save()
    {

    }
}
