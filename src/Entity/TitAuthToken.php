<?php
namespace Tit\Auth\Entity;

use Carbon\Carbon;
use Tit\lib\Entity\Entity;

/**
 * Class TitAuthToken
 * @package Tit\Auth\Entity
 *
 * Source : https://paragonie.com/blog/2015/04/secure-authentication-php-with-long-term-persistence
 */
class TitAuthToken extends Entity {

    /**
     * @var int
     */
    protected $selector;

    /**
     * @var int
     */
    protected $idUser;

    /**
     * @var string
     */
    protected $token;

    /**
     * @var Carbon
     */
    protected $expire;

    /**
     * Check if the token has expired.
     * @return bool
     */
    public function hasExpired(){
        return Carbon::now()->gt($this->expire);
    }

    /**
     * @param int $selector
     * @return $this
     */
    public function setSelector(int $selector){
        // For php7.1 public function setSelector(int $id): TitAuthToken{
        $this->selector = $selector;
        return $this;
    }

    /**
     * @param int $id
     * @return $this
     */
    public function setIdUser(int $id){
        // For php7.1 public function setIdUser(int $id): TitAuthToken{
        $this->idUser = $id;
        return $this;
    }

    /**
     * @param string $token
     * @return $this
     */
    public function setToken(string $token){
        // For php7.1 public function setToken(string $token): TitAuthToken{
        $this->token = $token;
        return $this;
    }

    /**
     * @param Carbon $expire
     * @return $this
     */
    public function setExpire(Carbon $expire){
        // For php7.1 public function setExpire(Carbon $expire): TitAuthToken{
        $this->expire = $expire;
        return $this;
    }

    /**
     * @return int
     */
    public function selector(){ return $this->selector; }
    // For php7.1 public function selector(): int{ return $this->selector; }

    /**
     * @return int
     */
    public function idUser(){ return $this->idUser; }
    // For php7.1 public function idUser(): int{ return $this->idUser; }

    /**
     * @return string
     */
    public function token(){ return $this->token; }
    // For php7.1 public function token(): string{ return $this->token; }

    /**
     * @return Carbon
     */
    public function expire(){ return $this->expire; }
    // For php7.1 public function expire(): Carbon{ return $this->expire; }

}
