<?php

namespace GAE;

require_once 'google/appengine/api/users/UserService.php';

use google\appengine\api\users\UserService;
use google\appengine\api\users\User;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Silex\Application;

class Auth
{
    private $user = null;
    private $loginURL;
    private $logoutURL;
    private $logged;

    public function __construct(Application $application, User $user = null)
    {
        $this->user = $user;

        if (is_null($user)) {
            $this->loginURL = UserService::createLoginURL($application['auth.onlogin.callback.url']);
            $this->logged = false;
        } else {
            $this->logged = true;
            $this->logoutURL = UserService::createLogoutURL($application['auth.onlogout.callback.url']);
        }
    }

    /**
     * @return RedirectResponse
     */
    public function getRedirectToLogin()
    {
        return new RedirectResponse($this->getLoginUrl());
    }

    /**
     * @return bool
     */
    public function isLogged()
    {
        return $this->logged;
    }

    /**
     * @return string
     */
    public function getLoginUrl()
    {
        return $this->loginURL;
    }

    /**
     * @return string
     */
    public function getLogoutUrl()
    {
        return $this->logoutURL;
    }

    /**
     * @return user|null
     */
    public function getUser()
    {
        return $this->user;
    }
}
