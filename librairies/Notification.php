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
            echo '<div class="alert alert-danger alert-dismissible fade show m-2" role="alert"><i class="bi bi-exclamation-triangle-fill"></i> ' . $_SESSION['error'] . '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
            unset($_SESSION['error']);
        }
        if (isset($_SESSION['success'])) {
            echo '<div class="alert alert-success alert-dismissible fade show m-2" role="alert"><i class="bi bi-check-circle-fill"></i> ' . $_SESSION['success'] . '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
            unset($_SESSION['success']);
        }
    }
}
