<?php 

namespace Controllers;

use Controllers\Controller;

class HomeController extends Controller
{
    protected $dir;

    function __construct()
    {
        $this->dir = '../app/views/';
    }

    public function index()
    {
        $template = $this->dir . 'welcome.php';
        include_once '../app/views/layouts/default.php';
    }
}