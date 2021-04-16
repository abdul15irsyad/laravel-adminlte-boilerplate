<?php
namespace App\Helpers;
 
class TitleHelper {
    public static function all_title($title) {
        $titles = [
            'users' => [
                __('users.users'),__('users.create-user'),__('users.update-user'),
            ],
            'roles' => [
                __('roles.roles'),__('roles.create-role'),
            ],
            'permission-roles' => [
                __('permission-roles.permission-roles'),__('permission-roles.create-permission-role'),
            ],
        ];
        $titles['user-management'] = [...$titles['users'],...$titles['roles'],...$titles['permission-roles']];
        return $titles[$title];
    }
}