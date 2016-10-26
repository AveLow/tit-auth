<?php
namespace Tit\Auth\Manager;

use Tit\Auth\Entity\TitAuthToken;
use Tit\Auth\Entity\TitAuthUser;

/**
 * Interface TitAuthManager
 * @package Tit\Auth\Manager
 *
 * Interface that should be implement by the user manager.
 */
interface TitAuthManager{

    /**
     * Return TitAuthUser by the id.
     * @param int $id
     * @return TitAuthUser
     */
    public function getById(int $id);
    // For php7.1 public function getById(int $id): TitAuthUser;

    /**
     * Return TitAuthToken by the cookies.
     * @param  int $selector
     * @return TitAuthToken
     */
    public function getToken(int $selector);
    // For php7.1 public function getToken(int $selector): TitAuthToken;

    /**
     * Remove TitAuthToken by the user's id.
     * @param  int $userId
     * @return bool
     */
    public function removeToken(int $userId);
    // For php7.1 public function removeToken(int $userId): bool;

    /**
     * Add TitAuthToken in the database.
     * @param  TitAuthToken $tokenAuth
     * @return bool
     */
    public function addToken(TitAuthToken $tokenAuth);
    // For php7.1 public function addToken(TitAuthToken $tokenAuth): bool;

}
