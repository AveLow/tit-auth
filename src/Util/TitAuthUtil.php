<?php
namespace Tit\Auth\Util;

use Carbon\Carbon;
use Slim\App;
use Tit\Auth\Entity\TitAuthToken;
use Tit\Auth\Entity\TitAuthUser;
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
     * @param TitAuthUser $user
     */
    public function setTokenCookie(TitAuthUser $user){
    // For php 7.1 public function setTokenCookie(TitAuthUser $user): void{
        $this->manager->removeToken($user->id());

        do {
            $selector = rand(0, 9999999999);
        }while($this->manager->getToken($selector) != null);

        $token = $this->generateToken();
        $tokenHash = $this->hashPassword($token);
        $expire = Carbon::now()->addMonth();

        $tokenAuth = new TitAuthToken(array(
            "selector" => $selector,
            "idUser" => $user->id(),
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
