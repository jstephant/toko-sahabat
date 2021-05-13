<?php

namespace App\Services\User;

use App\Services\IDefault;

interface IUser extends IDefault
{
    public function login($username, $password);
    public function changePassword($id, $new_password);

    public function findByUsername($username);
    public function findByEmail($email);

    public function getActive();
    public function list($keyword, $start, $length, $order);

    public function createUserRole($input);
    public function deleteUserRole($user_id, $role_id);
    public function setUserRole($user_id, $roles);
}
