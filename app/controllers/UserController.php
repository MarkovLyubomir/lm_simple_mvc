<?php 

namespace Controllers;

use Controllers\Controller;

class LoginController extends Controller
{
    protected $dir;

    function __construct()
    {
        $this->dir = '../app/views/user/';
    }

    public function index()
    {
        $template = $this->dir . 'index.php';
        include_once '../app/views/layouts/default.php';
    }

    public function login()
    {
        $template = $this->dir . 'login.php';
        include_once '../app/views/layouts/default.php';
    }

}