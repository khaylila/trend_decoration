<?php

namespace App\Controllers;

use Codeigniter\Shield\Controllers\LoginController as ShieldLoginController;
use CodeIgniter\Shield\Config\Auth;
use CodeIgniter\Shield\Authentication\Authenticators\Session;

class LoginController extends ShieldLoginController
{
    public function loginView()
    {
        if (auth()->loggedIn()) {
            return redirect()->to(config(Auth::class)->loginRedirect());
        }

        /** @var Session $authenticator */
        $authenticator = auth('session')->getAuthenticator();

        // If an action has been defined, start it up.
        if ($authenticator->hasAction()) {
            return redirect()->route('auth-action-show');
        }

        return $this->view(setting('Auth.views')['login']);
    }
}
