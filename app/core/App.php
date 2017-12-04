<?php 

include_once '../app/config/db.php';
include_once '../lib/Database.php';
include_once '../lib/Auth.php';
include_once '../app/models/Master.php';
include_once '../app/controllers/Controller.php';

class App
{
    protected $model = 'Master';
    protected $controller = 'HomeController';
    protected $method = 'index';
    protected $params = [];
    protected $adminRoute = false;

    function __construct()
    {
        $request = $this->parseUrl();
        $unknownController = true;

        if (!empty($request)) {

            if (($request[0] === 'admin')) {
                $this->adminRoute = true;
                $this->controller = 'admin/AdminController';
            }

            $controller = ucfirst($request[0]) . 'Controller';
            $model = substr(ucfirst($request[0]), 0, -1);

            if (file_exists('../app/controllers/' . $controller . '.php')) {
                $this->controller = $controller;
                unset($request[0]);
                $unknownController = false;
            }

            if(file_exists('../app/models/' . $model . '.php')) {
                $this->model = $model;
            }
        }

        require_once '../app/models/' . $this->model . '.php';
        require_once '../app/controllers/' . $this->controller . '.php';

        $controllerNamespace = '\Controllers\\' . $this->controller;

        if ($this->adminRoute) {
            $controllerName = explode('/', $this->controller);
            $controllerNamespace = '\Controllers\\Admin\\' . $controllerName[1];
        }
        
        $this->controller = new $controllerNamespace;

        if (isset($request[1])) {
            if (method_exists($this->controller, $request[1])) {
                $this->method = $request[1];
                unset($request[1]);
            } else {
                $request = [];
            }
        }

        if ($request && !$unknownController) {
            $this->params = array_values($request);
        }

        if (method_exists($this->controller, $this->method)) {

            call_user_func_array([$this->controller, $this->method], $this->params);
        } else {
            $this->masterController->home();
        }

    }

    public function parseUrl()
    {
        $request = $_SERVER['REQUEST_URI'];
        $request = trim($request, '/');

        if ($request != '') {
            return explode('/', $request);
        }
    }
}