<?php

namespace App\Frontend\Modules\Customer;

use Library\Entities\Customer;
use Library\HTTPRequest;
use Library\Models\CustomerManagerPDO;

class CustomerController extends \Library\Abstracts\Controller
{
    public function executeIndex(HTTPRequest $request)
    {
        $this->page->addVar('title', 'Connexion');
        if ($request->postExists('login')) {
            $email = $request->postData('email');
            $password = $request->postData('password');
            /** @var CustomerManagerPDO $manager */
            $manager = $this->managers->getManagerOf('Customer');
            if ($customer = $manager->getBy(compact('email'), true)) {
                if (password_verify($password, $customer->password())) {
                    $this->app->user()->setAuthenticated($customer->id(), 'Customer');
                    $this->app->user()->setFlash('success', 'Connexion réussi');
                    $this->app->httpResponse()->redirect('/');
                }
            }
            $this->app->user()->setFlash('error', 'Le pseudo ou le mot de passe est incorrect.');
            $this->app->httpResponse()->redirect('/login.html');
        }
    }

    public function executeRegister(HTTPRequest $request)
    {
        $this->page->addVar('title', 'Inscription');
        if ($request->postExists('register')) {
            $email = $request->postData('email');
            $password = $request->postData('password');
            $confirm_password = $request->postData('confirm_password');
            if (!$email || !$password || !$confirm_password) {
                $this->app->user()->setFlash('error', 'L\'email ou le mot de passe est incorrect.');
                $this->app->httpResponse()->redirect('/register.html');
            }

            if (strlen($password) < 6) {
                $this->app->user()->setFlash('error', 'Le mot de passe doit avoir au minimum 6 caractères.');
                $this->app->httpResponse()->redirect('/register.html');
            }

            if ($password !== $confirm_password) {
                $this->app->user()->setFlash('error', 'Le mot de passe doit être confirmé.');
                $this->app->httpResponse()->redirect('/register.html');
            }

            /** @var CustomerManagerPDO $manager */
            $manager = $this->managers->getManagerOf('Customer');
            if ($manager->getBy(compact('email'))) {
                $this->app->user()->setFlash('error', 'L\'email est déjà utilisé.');
                $this->app->httpResponse()->redirect('/register.html');
            }
            $customer = new Customer(compact('email', 'password'));
            $manager->add($customer);
            $this->app->user()->setFlash('success', 'Le compte a bien été créé');
            $this->app->httpResponse()->redirect('/login.html');
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

    public function executeLogout(HTTPRequest $request)
    {
        if ($this->app->user()->isAuthenticated()) {
            $this->app->user()->setAuthenticated(false);
            $this->app->httpResponse()->redirect('/login.html');
        }
        $this->app->httpResponse()->redirect('.');
    }
}