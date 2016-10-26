<?php
namespace Tit\Auth\Manager;

use Tit\Auth\Entity\TitAuthUser;

/**
 * Interface TitAuthManager
 * @package Tit\Auth\Manager
 *
 * Interface that should be implement by the user manager.
 */
interface TitAuthManager{

    /**
     * Return TitAuthUser by the session.
     * @param  string $token
     * @return TitAuthUser
     */
    public function getByTokenSession(string $token);
    // For php7.1 public function getByTokenSession(string $token): TitAuthUser;

    /**
     * Return TitAuthUser by the cookies.
     * @param  string $token
     * @return TitAuthUser
     */
    public function getByTokenCookie(string $token);
    // For php7.1 public function getByTokenCookie(string $token): TitAuthUser;

}
