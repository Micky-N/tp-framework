<?php

namespace App\Backend\Modules\Connexion;

use Library\Abstracts\Controller;
use Library\HTTPRequest;

class ConnexionController extends Controller
{
    public function executeIndex(HTTPRequest $request)
    {
        $this->page->addVar('title', 'Connexion');
        if ($request->postExists('login')) {
            $login = $request->postData('login');
            $password = $request->postData('password');
            if ($login == $this->app->config()->get('login') && $password == $this->app->config()->get('pass')) {
                $this->app->user()->setAuthenticated();
                $this->app->httpResponse()->redirect('/admin');
            } else {
                $this->app->user()->setFlash('Le pseudo ou le mot de passe est incorrect.');
            }
        }
    }

    public function executeLogout(HTTPRequest $request)
    {
        $this->app->user()->setAuthenticated(false);
        $this->app->httpResponse()->redirect('/');
    }
}