<?php

namespace App\Backend\Modules\Connexion;

use Library\Abstracts\Controller;
use Library\Entities\User;
use Library\HTTPRequest;
use Library\Models\UserManagerPDO;

class ConnexionController extends Controller
{
    public function executeIndex(HTTPRequest $request)
    {
        $this->page->addVar('title', 'Connexion');
        if ($request->postExists('login')) {
            $email = $request->postData('email');
            $password = $request->postData('password');
            /** @var UserManagerPDO $manager */
            $manager = $this->managers->getManagerOf('User');
            if ($user = $manager->getBy(compact('email'))) {
                $user = reset($user);
                if (password_verify($password, $user->password())) {
                    $this->app->user()->setAuthenticated($user->id(), 'User');
                    $this->app->httpResponse()->redirect('/admin');
                }
            }
            $this->app->user()->setFlash('error', 'Le pseudo ou le mot de passe est incorrect.');
        }
    }

    public function executeForgotPassword(HTTPRequest $request)
    {
        $this->page->addVar('title', 'Mot de passe oublié');
        if ($request->postExists('sendLink')) {
            $email = $request->postData('email');
            $this->app->httpResponse()->redirect('/login.html');
        }
    }

    public function executeRegister(HTTPRequest $request)
    {
        $this->page->addVar('title', 'Inscription');
        if ($request->postExists('register')) {
            $email = $request->postData('email');
            $password = $request->postData('password');
            $confirm_password = $request->postData('password');
            if (!$email || !$password || !$confirm_password) {
                $this->app->user()->setFlash('error', 'L\'email ou le mot de passe est incorrect.');
                $this->app->httpResponse()->redirect('/admin/register.html');
            }
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $this->app->user()->setFlash('error', 'L\'email n\'est pas correct.');
                $this->app->httpResponse()->redirect('/admin/register.html');
            }

            if (strlen($password) < 6) {
                $this->app->user()->setFlash('error', 'Le mot de passe doit avoir au minimum 6 caractères.');
                $this->app->httpResponse()->redirect('/admin/register.html');
            }

            if ($password !== $confirm_password) {
                $this->app->user()->setFlash('error', 'Le mot de passe doit être confirmé.');
                $this->app->httpResponse()->redirect('/admin/register.html');
            }
            /** @var UserManagerPDO $manager */
            $manager = $this->managers->getManagerOf('User');
            if ($manager->getBy(compact('email'))) {
                $this->app->user()->setFlash('error', 'L\'email est déjà utilisé.');
                $this->app->httpResponse()->redirect('/admin/register.html');
            }
            $user = new User(compact('email', 'password'));
            $manager->add($user);
            $this->app->httpResponse()->redirect('/admin/login.html');
        }
    }

    public function executeLogout(HTTPRequest $request)
    {
        if ($this->app->user()->isAuthenticated()) {
            $this->app->user()->setAuthenticated(false);
            $this->app->httpResponse()->redirect('/admin/login.html');
        }
        $this->app->httpResponse()->redirect('.');
    }
}