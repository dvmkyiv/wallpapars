<?php

class Session{

    protected static $flash_message;


    /**
     * @param mixed $flash_message
     */
    public static function setFlash($flash_message)
    {
        self::$flash_message = $flash_message;
    }


    public static function hasFlash()
    {
        return !is_null(self::$flash_message);
    }


    /**
     *
     */
    public static function flash()
    {
        echo self::$flash_message;
        self::$flash_message = null;
    }


    public static function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }


    public static function get($key)
    {
        if ( isset($_SESSION[$key]) )
        {
            return $_SESSION[$key];
        }
        return null;
    }


    public static function delete($key)
    {
        if ( isset($_SESSION[$key]) )
        {
            unset($_SESSION[$key]);
        }
    }


    public static function print_key($key)
    {
        if ( isset($_SESSION[$key]) )
        {
            $print_message = $_SESSION[$key];
            unset($_SESSION[$key]);
            return $print_message;
        }
        return null;
    }

    public static function destroy()
    {
        session_destroy();
    }
}