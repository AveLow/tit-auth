<?php
namespace Tit\Auth\Entity;

use Tit\lib\Entity\Entity;

/**
 * Class TitAuthUser
 * @package Tit\Auth\Entity
 *
 * Abstract class for the entity user that should be used with TitAuth.
 */
abstract class TitAuthUser extends Entity {

    /**
     * The user's login.
     * @var string
     */
    protected $login;

    /**
     * The user's mail.
     * @var string
     */
    protected $mail;

    /**
     * The user's password.
     * @var string
     */
    protected $password;

    /**
     * The user's roles.
     * It's an array of TitAuthRole.
     *
     * @var int[]
     */
    protected $roles;


    /**
     * Add a role to the user.
     *
     * @param int $id
     * @return TitAuthUser
     */
    public function addRole(int $id){
    // For php7.1 public function addRole(int $id): TitAuthUser{
        if (!$this->hasRole($id)){
            $this->roles[] = $id;
        }
        return $this;
    }

    /**
     * Remove a role from the user's roles.
     *
     * @param int $id
     * @return TitAuthUser
     */
    public function removeRole(int $id){
        if ($this->hasRole($id)){
            unset($this->roles[array_search($id, $this->roles)]);
        }
        return $this;
    }

    /**
     * Check if the user has a role or not.
     *
     * @param int $id
     * @return bool
     */
    public function hasRole(int $id){
    // For php7.1 public function hasRole(int $id): bool{
        return in_array($id, $this->roles);
    }

    /**
     * Setter
     * @param string $login
     * @return TitAuthUser
     */
    public function setLogin(string $login){
    // For php7.1 public function setLogin(string $login): TitAuthUser{
        $this->login = $login;
        return $this;
    }

    /**
     * Setter
     * @param string $mail
     * @return TitAuthUser
     */
    public function setMail(string $mail){
    // For php7.1 public function setMail(string $mail): TitAuthUser{
        $this->mail = $mail;
        return $this;
    }

    /**
     * Setter
     * @param string $password
     * @return TitAuthUser
     */
    public function setPassword(string $password){
    // For php7.1 public function setPassword(string $password): TitAuthUser{
        $this->password = $password;
        return $this;
    }

    /**
     * Setter
     * @param array $roles
     * @return TitAuthUser
     */
    public function setRoles(array $roles){
    // For php7.1 public function setRoles(array $roles): TitAuthUser{
        $this->roles = $roles;
        return $this;
    }

    /**
     * Getter
     * @return string
     */
    public function login(){ return $this->login; }
    // For php7.1 public function login(): string{ return $this->login; }


    /**
     * Getter
     * @return string
     */
    public function mail(){ return $this->mail; }
    // For php7.1 public function mail(): string{ return $this->mail; }


    /**
     * Getter
     * @return string
     */
    public function password(){ return $this->password; }
    // For php7.1 public function password(): string{ return $this->password; }


    /**
     * Getter
     * @return int[]
     */
    public function roles(){ return $this->roles; }
    // For php7.1 public function roles(): array{ return $this->roles; }
}
