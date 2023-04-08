<?php

namespace App\Model\User;


class SessionUser
{
	private $username;
	private $userid;
	// private acls;


	public function __construct()
	{
		if ( isset( $_SESSION['user'] ) )
		{
			$this->username = $_SESSION['user']['username'];
			$this->userid = $_SESSION['user']['userid'];
		}
	}

	/* Save User into $_SESSION */
	public function save()
	{

	}
	public function setAuthentication($auth)
	{
		$_SESSION['user']['auth'] = $auth;
	}
}
