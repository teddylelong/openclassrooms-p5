<?php

use Models\User;

class AccessControl
{
    /**
     * Check if current $_SESSION exist and matches with an existing admin user
     *
     * @return bool
     */
    public static function isUserAdmin(): bool
    {
        if (isset($_SESSION['user_id'])) {

            $id = $_SESSION['user_id'];

            $userModel = new User();
            $user = $userModel->find($id);

            if ($user['is_admin'] == true) {
                return true;
            }
        }
        return false;
    }
}