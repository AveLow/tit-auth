<?php
namespace Tit\Auth\Role;

/**
 * Interface TitAuthRole
 * @package Tit\Auth\Role
 *
 * This interface is usefull just to know if the class is a role or not.
 */
interface TitAuthRole{

    /**
     * Return the name of the role.
     * @return string
     */
    public static function name();

    /**
     * Return the id of the role.
     * @return int
     */
    public static function id();

}