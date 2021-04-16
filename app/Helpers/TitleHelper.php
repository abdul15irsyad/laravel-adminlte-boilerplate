<?php
namespace App\Helpers;
 
class TitleHelper {
    public static function all_title($title) {
        $titles = [
            'users' => [
               'Users','Create User','Update User',
            ],
            'roles' => [
                'Roles','Create Role','Update Role',
            ],
            'permission-roles' => [
                'Permission Roles','Create Permission Role','Update Permission Role',
            ],
        ];
        $titles['user-management'] = [...$titles['users'],...$titles['roles'],...$titles['permission-roles']];
        return $titles[$title];
    }
}