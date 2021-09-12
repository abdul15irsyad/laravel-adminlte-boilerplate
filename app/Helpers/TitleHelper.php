<?php
namespace App\Helpers;
 
class TitleHelper {
    public static function all_title($title) {
        $titles = [
            'users' => [
               'Users','Create User','Update User',
            ],
            'roles' => [
                'Roles','Detail Role','Create Role','Update Role',
            ],
        ];
        $titles['user-management'] = [...$titles['users'],...$titles['roles']];
        return $titles[$title];
    }
}