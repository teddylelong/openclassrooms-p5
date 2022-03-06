<?php

use Models\User;

class AccessControl
{
    private const DENIED_MSG = "Vous n'avez pas les autorisations requises pour accéder à cette page.";
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

            if ($user->getIsAdmin() == true) {
                return true;
            }
        }
        return false;
    }

    public static function denied() {
        Notification::set('error', self::DENIED_MSG);
        Http::redirect('/login/');
    }
}