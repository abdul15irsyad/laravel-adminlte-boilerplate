<?php
namespace App\Helpers;
 
class TitleHelper {
    public static function all_title($title) {
        $titles = [
            'users' => [
               'Users', 'Detail User','Create User','Update User',
            ],
            'roles' => [
                'Roles','Detail Role','Create Role','Update Role',
            ],
            'permissions' => [
                'Permissions','Detail Permissions',
            ],
            'activity-log' => [
                'Activity Log','Detail Activity Log',
            ],
        ];
        $titles['account'] = [...$titles['users'],...$titles['roles'],...$titles['permissions'],...$titles['activity-log']];
        return $titles[$title];
    }
}