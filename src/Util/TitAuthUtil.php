<?php
namespace Tit\Auth\Util;

use Carbon\Carbon;
use Slim\App;
use Tit\Auth\Entity\TitAuthToken;
use Tit\Auth\Manager\TitAuthManager;
use Tit\lib\AppComponent;
use Tit\lib\Components\CookieHandler;

class TitAuthUtil extends AppComponent {

    /**
     * @var TitAuthManager
     */
    protected $manager;

    /**
     * @var CookieHandler
     */
    protected $cookie;

    /**
     * TitAuthUtil constructor.
     * @param App $app
     * @param TitAuthManager $manager
     * @param CookieHandler $cookie
     */
    public function __construct(App $app, TitAuthManager $manager, CookieHandler $cookie){
        $this->manager = $manager;
        $this->cookie = $cookie;
        parent::__construct($app);
    }

    /**
     * Hash a password
     * @param string $password
     * @return bool|string
     */
    public function hashPassword(string $password){
    // For php7.1 public function hashPassword(string $password): bool|string{
        return password_hash($password, PASSWORD_DEFAULT);
    }

    /**
     * Check if the password correspond to the hash.
     * @param string $password
     * @param string $hash
     * @return bool
     */
    public function verifyPassword(string $password, string $hash){
    // For php7.1 public function verifyPassword(string $password, string $hash): bool{
        return password_verify($password, $hash);
    }


    public function verifyTokenCookie(string $token, TitAuthToken $tokenAuth){
    // For php7.1 public function verifyTokenCookie(string $token, TitAuthToken $tokenAuth): bool{
        return $this->verifyPassword($token, $tokenAuth->token());
    }

    /**
     * Set the cookie for the token remember me
     * @param int $id
     */
    public function setTokenCookie(int $id){
        // For php 7.1 public function setTokenCookie(int $id): void{
        $expire = Carbon::now()->addMonth();
        $this->setTokenCookieWithExpire($id, $expire);
    }

    /**
     * Set the cookie for the token remember me with expire date choice.
     * @param int $id
     * @param Carbon $expire
     */
    public function setTokenCookieWithExpire(int $id, Carbon $expire){
        // For php 7.1 public function setTokenCookieWithExpire(int $id, Carbon $expire): void{
        $this->manager->removeToken($id);

        do {
            $selector = rand(0, 999999999);
        }while($this->manager->getToken($selector) != null);

        $token = $this->generateToken();
        $tokenHash = $this->hashPassword($token);

        $tokenAuth = new TitAuthToken(array(
            "selector" => $selector,
            "idUser" => $id,
            "token" => $tokenHash,
            "expire" => $expire
        ));

        $this->manager->addToken($tokenAuth);

        $this->cookie->authenticate($selector, $token);
    }

    /**
     * Generate a random string
     * @param int $length
     * @return string
     */
    public function generateToken($length = 20){
        return bin2hex(random_bytes($length));
    }


}
