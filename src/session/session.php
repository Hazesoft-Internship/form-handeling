<?php
namespace App\session;

class session
{
    public static $instance;

    public function __construct()
    {
        if(session_status() == PHP_SESSION_NONE)
        {
            session_start();
        }
    }

    public static function getInstance()
    {
      if(self::$instance==null)
        {
           self::$instance= new session();
        }
    return self::$instance;
    }

    public function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public function get($key)
    {
        return $_SESSION[$key];
    }
    public function destroySession()
    {
        if(session_status() == PHP_SESSION_NONE)
        {}
        else
        {
            echo "you destroyed the session";
            die();
            session_destroy();
        }
    }
}
?>