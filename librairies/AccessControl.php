<?php

use Models\UserModel;

class AccessControl
{
    private const DENIED_MSG = "Vous n'avez pas les autorisations requises pour accéder à cette page.";

    /**
     * Check if current $_SESSION exist and matches with an existing admin user
     *
     * @return mixed
     */
    // Todo : a instancier dans Controllers\Controller
    public static function adminRightsNeeded()
    {
        if (isset($_SESSION['user_id'])) {

            $id = $_SESSION['user_id'];

            if (self::isUserAdmin($id)) {
                return true;
            }
            self::denied();
        }
        self::denied();
    }

    public static function isUserAdmin(int $id): bool
    {
        $userModel = new UserModel();
        $user = $userModel->find($id);

        if (!$user) {
            return false;
        }

        if ($user->getIsAdmin() == true) {
            return true;
        }

        return false;
    }

    public static function denied() {
        Notification::set('error', self::DENIED_MSG);
        Http::redirect('/login/');
    }
}