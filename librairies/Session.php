<?php

class Session{

    /**
     * Create a new Session
     *
     * @param mixed $key Name of the session
     * @param mixed $value Value of the session
     * @return void
     */
    public static function create($key, $value): void
    {
        $_SESSION[$key] = $value;
    }

    /**
     * Get a session
     *
     * @param mixed $key Name of the session
     * @return mixed|null
     */
    public static function get($key)
    {
        return (isset($_SESSION[$key]) ? $_SESSION[$key] : null);
    }

    /**
     * Unset a session
     *
     * @param mixed $key Name of the session
     * @return void
     */
    public static function destroy($key): void
    {
        unset($_SESSION[$key]);
    }
}
