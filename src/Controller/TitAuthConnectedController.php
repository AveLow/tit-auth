<?php
namespace Tit\Auth\Controller;

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;
use Tit\Auth\Entity\TitAuthUser;
use Tit\Auth\Error\NotAllowedException;
use Tit\Auth\Error\NotConnectedException;
use Tit\Auth\Manager\TitAuthManager;
use Tit\Auth\Util\TitAuthUtil;
use Tit\lib\Components\Controller;
use Tit\lib\Components\CookieHandler;
use Tit\lib\Components\SessionHandler;

/**
 * Class TitAuthConnectedController
 * @package Tit\Auth\Controller
 *
 * Controller that only allow access to connected user.
 */
abstract class TitAuthConnectedController extends Controller {



    /**
     * The connected user.
     * @var TitAuthUser
     */
    protected $user;

    /**
     * @var TitAuthManager
     */
    protected $manager;

    /**
     * @var SessionHandler
     */
    protected $session;

    /**
     * @var CookieHandler
     */
    protected $cookie;

    /**
     * @var TitAuthUtil
     */
    protected $util;

    /**
     * List of roles need to access this controller.
     * @var int[]
     */
    protected $roles = array();

    /**
     * TitAuthController constructor.
     * @param App $app
     * @param TitAuthManager $manager
     * @param SessionHandler $session
     * @param CookieHandler $cookie
     * @param TitAuthUtil $util
     */
    public function __construct(App $app, TitAuthManager $manager, SessionHandler $session, CookieHandler $cookie, TitAuthUtil $util){
        parent::__construct($app);

        $this->manager = $manager;
        $this->session = $session;
        $this->cookie = $cookie;
        $this->util = $util;
    }


    /**
     * @param string $action
     * @param Request $req
     * @param Response $resp
     * @param array $args
     * @return \Psr\Http\Message\ResponseInterface
     * @throws NotAllowedException
     * @throws NotConnectedException
     */
    public function exec(string $action,Request $req, Response $resp, array $args){
    // For php7.1 public function exec(string $action,RequestInterface $req, ResponseInterface $resp, array $args): ResponseInterface{
        if (!$this->checkConnected()){
            $this->session->disconnect();
            $this->cookie->disconnect();

            throw new NotConnectedException();
        }


        if (!$this->checkRole()){
            throw new NotAllowedException();
        }

        return parent::exec($action, $req, $resp, $args);
    }

    /**
     * Check if a user is connected.
     * @return bool
     */
    public function checkConnected(){
    // For php7.1 public function checkConnected(): bool{
        if ($this->session->isConnected()){
            $idUser = $this->session->getConnectedId();
            $user = $this->manager->getById($idUser);

            if ($user == null)
                return false;

            $this->user = $user;
            return true;
        }elseif ($this->cookie->isConnected()){
            $selector = $this->cookie->getConnectedSelector();
            $tokenAuth = $this->manager->getToken($selector);

            if ($tokenAuth == null)
                return false;

            if ($tokenAuth->hasExpired()){
                $this->manager->removeToken($tokenAuth->idUser());
                return false;
            }

            $tokenCookie = $this->cookie->getConnectedToken();

            if (!$this->util->verifyTokenCookie($tokenCookie, $tokenAuth))
                return false;

            $user = $this->manager->getById($tokenAuth->idUser());

            if ($user==null)
                return false;

            $this->user = $user;
            $this->session->authenticate($user->id());
            return true;
        }
        return false;
    }

    /**
     * Check if a user has a role.
     *
     * @return bool
     */
    public function checkRole(){
    // For php7.1 public function checkRole(): bool{
        foreach($this->roles as $role){
            if (!$this->user->hasRole($role))
                return false;
        }
        return true;
    }
}
