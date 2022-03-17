<?php

class Notification
{
    /**
     * Initialize a $_SESSION notification
     *
     * @param string $type Error | Success
     * @param string $message The message to display
     * @return void
     */
    public static function set(string $type, string $message): void
    {
        if ($type == 'error' || $type == 'success') {
             $_SESSION[$type] = $message;
        }
    }

    /**
     * Display the message if $_SESSION exists
     *
     * @return void
     */
    public static function display(): void
    {
        if (isset($_SESSION['error'])) {
            echo '<div class="error message"> Erreur : ' . $_SESSION['error'] . '</div>';
            unset($_SESSION['error']);
        }
        if (isset($_SESSION['success'])) {
            echo '<div class="success message">' . $_SESSION['success'] . '</div>';
            unset($_SESSION['success']);
        }
    }
}
