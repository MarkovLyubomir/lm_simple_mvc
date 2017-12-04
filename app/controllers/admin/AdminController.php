<?php 

namespace Controllers\Admin;

use Controllers\Controller;

class AdminController extends Controller
{
    
    protected $dir;
    protected $loginUrl = '/login';

    function __construct()
    {
        parent::__construct();
        $this->dir = '../app/views/admin/';

        var_dump(empty($this->loggedUser));

        if (empty($this->loggedUser)) {
            header('Location: ' . $this->loginUrl);
            die();
        }
    }

    public function index()
    {
        $template = $this->dir . 'index.php';
        include_once '../app/views/layouts/default.php';
    }
}