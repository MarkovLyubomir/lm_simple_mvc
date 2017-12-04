<?php 

namespace Controllers;

use Controllers\Controller;

class LoginController extends Controller
{
    protected $dir;

    function __construct()
    {
        parent::__construct();
        $this->dir = '../app/views/login/';
    }

    public function index()
    {
        $template = $this->dir . 'index.php';
        include_once '../app/views/layouts/default.php';
    }

    public function login()
    {
        if (!empty($_POST['username']) &&
            !empty($_POST['password'])) {
            $isLogged = $this->auth->login($_POST['username'], $_POST['password']);

            header("Location: /books/list");
            die();
        }
    }

    public function logout()
    {
        # code...
    }

}