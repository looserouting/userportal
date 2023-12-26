<?php

namespace App\Model;


class SessionUser
{
	private $username;
	private $userid;
	// private acls;

	public function get($param)
	{
		return $_SESSION['user'][$param];
	}

	/* Save User into $_SESSION */
	public function save($data)
	{
		unset($_SESSION['user']);
		foreach( $data as $key => $value ) {
			print_r($data);
			//$_SESSION['user'][$key] = $value;
		}
		
	}
}
