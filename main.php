<?php

require_once __DIR__.'/vendor/autoload.php';
require_once __DIR__.'/lib/GAE/LoginProvider.php';
require_once __DIR__.'/lib/GAE/Auth.php';

use Silex\Application;
use GAE\LoginProvider;
use GAE\Auth;

$app = new Application();
$app->register(new LoginProvider(), array(
    'auth.onlogin.callback.url'     => '/private',
    'auth.onlogout.callback.url'    => '/loggedOut',
));

/**
 * @var Auth $auth
 */
$auth = $app['GAE.auth']();

$app->get('/', function () use ($app, $auth) {
    return $auth->isLogged() ? $app->redirect('/private') : '<a href="' . $auth->getLoginUrl() . '">login</a>';
});

$app->get('/private', function() use ($app, $auth) {
    return $auth->isLogged() ? 'Hola ' . $auth->getUser()->getNickname() . '<a href="' . $auth->getLogoutUrl() . '">Logout</a>' : $auth->getRedirectToLogin();
});

$app->get('/loggedOut', function() use ($app, $auth) {
    return 'Gracias. <a href="' . $auth->getLoginUrl() . '">login</a>';
});

$app->run();
