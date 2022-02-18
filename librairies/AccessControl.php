<?php

use Models\User;

class AccessControl
{
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