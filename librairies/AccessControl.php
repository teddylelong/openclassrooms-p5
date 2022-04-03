<?php

use Models\UserModel;

class AccessControl
{
    private const DENIED_MSG = "Vous n'avez pas les autorisations requises pour accéder à cette page.";

    /**
     * Check if current $_SESSION exist and matches with an existing admin user
     *
     * @return void
     */
    public static function adminRightsNeeded(): void
    {
        if (Session::get('user_id')) {

            $user_id = Session::get('user_id');

            if (self::isUserAdmin($user_id)) {
                return;
            }
            self::denied();
        }
        self::denied();
    }

    /**
     * Check if user is admin or not.
     * Return true on success, false on failure
     *
     * @param int $user_id
     * @return bool
     */
    public static function isUserAdmin(int $user_id): bool
    {
        $userModel = new UserModel();
        $user = $userModel->find($user_id);

        if (!$user) {
            return false;
        }

        if ($user->getIsAdmin() == true) {
            return true;
        }

        return false;
    }

    /**
     * Redirect user to login page and display a message.
     *
     * @return void
     */
    public static function denied() {
        Notification::set('error', self::DENIED_MSG);
        Http::redirect('/login/');
    }
}