<?php

declare(strict_types=1);

namespace App\Controllers\Auth;

use CodeIgniter\Shield\Controllers\LoginController as ShieldLoginController;
use CodeIgniter\Shield\Authentication\Authenticators\Session;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\ResponseInterface;

class LoginController extends ShieldLoginController
{

    use ResponseTrait;

    /**
     * Authenticate Existing User and Issue JWT.
     */
    public function jwtLogin(): ResponseInterface
    {
        // Get the validation rules
        $rules = $this->getValidationRules();

        // Validate credentials
        if (!$this->validateData($this->request->getJSON(true), $rules)) {
            return $this->fail(
                ['errors' => $this->validator->getErrors()],
                $this->codes['unauthorized']
            );
        }

        // Get the credentials for login
        $credentials             = $this->request->getJsonVar(setting('Auth.validFields'));
        $credentials             = array_filter($credentials);
        $credentials['password'] = $this->request->getJsonVar('password');

        /** @var Session $authenticator */
        $authenticator = auth('session')->getAuthenticator();

        // Check the credentials
        $result = $authenticator->check($credentials);

        // Credentials mismatch.
        if (!$result->isOK()) {
            // @TODO Record a failed login attempt

            return $this->failUnauthorized($result->reason());
        }

        // Credentials match.
        // @TODO Record a successful login attempt

        $user = $result->extraInfo();

        /** @var JWTManager $manager */
        $manager = service('jwtmanager');

        // Generate JWT and return to client
        $jwt = $manager->generateToken($user);

        return $this->respond([
            'status_code' => 200,
            'access_token' => $jwt,
        ]);
    }

    // public function loginView()
    // {
    //     if (auth()->loggedIn()) {
    //         return redirect()->to(config(Auth::class)->loginRedirect());
    //     }

    //     /** @var Session $authenticator */
    //     $authenticator = auth('session')->getAuthenticator();

    //     // If an action has been defined, start it up.
    //     if ($authenticator->hasAction()) {
    //         return redirect()->route('auth-action-show');
    //     }

    //     return $this->view(setting('Auth.views')['login']);
    // }
}
