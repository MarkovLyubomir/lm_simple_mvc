<?php 

namespace Controllers;

use \Lib\Auth;

class Controller
{
	protected $auth;
    protected $loggedUser;

	function __construct()
	{
		$this->auth = Auth::getInstance();
        $this->loggedUser = $this->auth->getLoggedUser();
	}

}