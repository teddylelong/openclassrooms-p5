<?php

use Models\UserModel;
use Models\RoleModel;

class AccessControl
{
    public const DENIED_MSG = "Vous n'avez pas les autorisations requises pour accéder à cette page.";
    public const BAD_PERM_MSG = "Désolé ! Vous n'avez pas les permissions nécessaires pour effectuer cette action.";

    /**
     * Check if current logged user has given role
     *
     * @param array $role_id
     * @return bool
     */
    public function hasRole(array $role_id): bool
    {
        $session = new Session();
        if ($session->get('user_id')) {

            $userModel = new UserModel();
            $user = $userModel->find($session->get('user_id'));

            if ($user && in_array($user->getFkRoleId(), $role_id, true)) {
                return true;
            }
            self::denied();
        }
        self::denied();
    }

    /**
     * check if current logged user has given permission
     * List of actual permissions :
     *
     * | article.create | article.index  | article.update | article.delete |
     * | comment.create | comment.manage | comment.delete |
     * | user.index     | user.create    | user.update    | user.delete
     *
     * @param string $permission
     * @return void
     */
    public function hasPermission(string $permission): void
    {
        $session = new Session();
        if ($session->get('user_id')) {

            $userModel = new UserModel();
            $user = $userModel->find($session->get('user_id'));

            $roleModel = new RoleModel();
            $role = $roleModel->find($user->getFkRoleId());

            $userPermissions = $role->getPermissions();

            $arrayPermissions = explode(', ', $userPermissions);

            if (in_array($permission, $arrayPermissions, true)) {
                return;
            }
            self::badPermissions();
        }
        self::badPermissions();
    }

    /**
     * Redirect user to login page and display a message.
     *
     * @return void
     */
    public static function denied(): void
    {
        $notification = new Notification();
        $notification->set('error', self::DENIED_MSG);
        $http = new Http();
        $http->redirect('/login/');
    }

    /**
     * Redirect user to dashboard page and display message.
     *
     * @return void
     */
    public static function badPermissions(): void
    {
        $notification = new Notification();
        $notification->set('error', self::BAD_PERM_MSG);
        $http = new Http();
        $http->redirect('/login/dashboard/');
    }
}