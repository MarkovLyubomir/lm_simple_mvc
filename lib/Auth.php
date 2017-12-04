<?php 

namespace Lib;

class Auth
{
    private $isLogged = false;
    private $loggedUser = [];

    function __construct()
    {
        session_set_cookie_params( 1800, '/');
        session_start();

        if (!empty($_SESSION['user'])) {
            $this->isLogged = true;
            $this->loggedUser = [
                'user' => $_SESSION['user']
            ];
        }
    }

    public static function getInstance()
    {
        static $instance = null;

        if (null === $instance) {
            $instance = new static();
        }

        return $instance;
    }

    public function isLoggedIn()
    {
        return $this->isLogged;
    }

    public function getLoggedUser()
    {
        return $this->loggedUser;
    }

    public function login($username, $password)
    {
        $dbObject = \Lib\Database::getInstance();
        $db = $dbObject->getDB();

        $query = 'SELECT `id`, `username` FROM users WHERE username = ? '
                . 'AND password = MD5( ? ) LIMIT 1';
        $statement = $db->prepare($query);

        $statement->bind_param('ss', $username, $password);
        $statement->execute();

        $result = $statement->get_result();

        if ($row = $result->fetch_assoc()) {
            $_SESSION['user'] = [
                    'id' => $row['id'],
                    'username' => $row['username']
                ];

            return true;
        }

        return false;
    }
}