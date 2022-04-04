<?php

class Notification
{
    public const TYPE_ERROR = 'error';
    public const TYPE_SUCCESS = 'success';

    /**
     * Initialize a $_SESSION notification
     *
     * @param string $type Error | Success
     * @param string $message The message to display
     * @return void
     */
    public function set(string $type, string $message): void
    {
        if ($type == self::TYPE_ERROR || $type == self::TYPE_SUCCESS) {
            Session::create($type, $message);
        }
    }

    /**
     * Display the message if $_SESSION exists
     *
     * @return void
     */
    public function display(): ?string
    {
        if (Session::get(self::TYPE_ERROR)) {
            $notification = '<div class="alert alert-danger alert-dismissible fade show p-3 mb-2" role="alert"><i class="bi bi-exclamation-triangle-fill"></i> ' . Session::get('error') . '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
            Session::destroy(self::TYPE_ERROR);
            return $notification;
        }

        if (Session::get(self::TYPE_SUCCESS)) {
            $notification = '<div class="alert alert-success alert-dismissible fade show m-2" role="alert"><i class="bi bi-check-circle-fill"></i> ' . Session::get('success') . '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
            Session::destroy(self::TYPE_SUCCESS);
            return $notification;
        }
        return null;
    }
}
