<?php 

namespace Lib;

class Database
{
    private static $db = null;
    
    function __construct()
    {
        $host = DB_HOST;
        $username = DB_USER;
        $password = DB_PASSWORD;
        $name = DB_NAME;

        $db = new \mysqli($host, $username, $password, $name);

        self::$db = $db;
    }

    public static function getInstance()
    {
        static $instance = null;

        if (null === $instance) {
            $instance = new static();
        }

        return $instance;
    }

    public function getDB()
    {
        return self::$db;
    }
}