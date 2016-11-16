<?php
namespace Tit\Auth\Controller;

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;
use Tit\lib\Components\Controller;
use Tit\lib\Components\CookieHandler;
use Tit\lib\Components\SessionHandler;

/**
 * Class TitAuthConnectedController
 * @package Tit\Auth\Controller
 *
 * Controller that only allow access to connected user.
 */
abstract class TitAuthNotConnectedController extends Controller {

    /**
     * @var SessionHandler
     */
    protected $session;

    /**
     * @var CookieHandler
     */
    protected $cookie;

    /**
     * TitAuthNotConnectedController constructor.
     * @param App $app
     * @param SessionHandler $session
     * @param CookieHandler $cookie
     */
    public function __construct(App $app, SessionHandler $session, CookieHandler $cookie){
        parent::__construct($app);

        $this->session = $session;
        $this->cookie = $cookie;
    }


    /**
     * @param string $action
     * @param Request $req
     * @param Response $resp
     * @param array $args
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function exec(string $action,Request $req, Response $resp, array $args){
        // For php7.1 public function exec(string $action,RequestInterface $req, ResponseInterface $resp, array $args): ResponseInterface{
        if ($this->session->isConnected() || $this->cookie->isConnected())
            return $this->redirectTo();

        return parent::exec($action, $req, $resp, $args);
    }

    /**
     * @param string $action
     * @param array $args
     * @return String
     */
    public function execMethod(string $action, array $args){
        // For php7.1 public function exec(string $action, array $args): String{
        if ($this->session->isConnected() || $this->cookie->isConnected())
            return $this->redirectTo();

        return parent::execMethod($action, $args);
    }

    /**
     * Redirection if a user is connected.
     * @return Response
     */
    abstract public function redirectTo();
    // For php 7.1 abstract public function redirectTo(): Response;
}
