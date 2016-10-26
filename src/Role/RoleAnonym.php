<?php
namespace Tit\Auth\Role;

/**
 * Class RoleAnonym
 * @package Tit\Auth\Role
 */
class RoleAnonym implements TitAuthRole{

    /**
     * Return name of RoleAnonym
     * @return string
     */
    public static function name(){
        return "Unknow";
    }

    /**
     * Return id of RoleAnonym
     * @return int
     */
    public static function id(){
        return 0;
    }

}