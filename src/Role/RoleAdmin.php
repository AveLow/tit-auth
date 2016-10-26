<?php
namespace Tit\Auth\Role;

/**
 * Class RoleAdmin
 * @package Tit\Auth\Role
 */
class RoleAdmin implements TitAuthRole{

    /**
     * Return name of RoleAdmin
     * @return string
     */
    public static function name(){
        return "Admin";
    }

    /**
     * Return id of RoleAdmin
     * @return int
     */
    public static function id(){
        return 2;
    }

}