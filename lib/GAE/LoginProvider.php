<?php

namespace GAE;

require_once 'google/appengine/api/users/UserService.php';
//require_once __DIR__.'/Auth.php';

use google\appengine\api\users\UserService;
use GAE\Auth;
use Silex\Application;
use Silex\ServiceProviderInterface;

class LoginProvider implements ServiceProviderInterface
{
    public function register(Application $application)
    {
        $application['GAE.auth'] = $application->protect(function() use ($application) {
            return new Auth($application, UserService::getCurrentUser());
        });
    }

    public function boot(Application $application)
    {
    }
}
