<?php
namespace Tit\Auth\Role;

/**
 * Class RoleUser
 * @package Tit\Auth\Role
 */
class RoleUser implements TitAuthRole{

    /**
     * Return name of RoleUser
     * @return string
     */
    public static function name(){
        return "User";
    }

    /**
     * Return id of RoleUser
     * @return int
     */
    public static function id(){
        return 1;
    }

}