<?php

declare(strict_types=1);

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\Response;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Shield\Authentication\Authenticators\JWT;
use CodeIgniter\Shield\Config\AuthJWT;
use CodeIgniter\Shield\Entities\User;
use Config\Services;

/**
 * JWT Authentication Filter.
 *
 * JSON Web Token authentication for web applications.
 */
abstract class JWTAuthFilter implements FilterInterface
{
    /**
     * Gets the JWT from the Request header, and checks it.
     *
     * @param array|null $arguments
     *
     * @return ResponseInterface|void
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        if (!$request instanceof IncomingRequest) {
            return;
        }

        helper('setting');

        /** @var JWT $authenticator */
        $authenticator = auth('jwt')->getAuthenticator();

        $token = $this->getTokenFromHeader($request);

        $result = $authenticator->attempt(['token' => $token]);

        if (!$result->isOK()) {
            return Services::response()
                ->setJSON([
                    'error' => $result->reason(),
                ])
                ->setStatusCode(ResponseInterface::HTTP_UNAUTHORIZED);
        }

        if (setting('Auth.recordActiveDate')) {
            $authenticator->recordActiveDate();
        }

        if (empty($arguments)) {
            return;
        }

        if ($this->isAuthorized($result->extraInfo(), $arguments)) {
            return;
        }

        return Services::response()
            ->setJSON([
                'error' => "You don't have access to do this!",
            ])
            ->setStatusCode(ResponseInterface::HTTP_UNAUTHORIZED);
    }

    private function getTokenFromHeader(RequestInterface $request): string
    {
        assert($request instanceof IncomingRequest);

        $config = config(AuthJWT::class);

        $tokenHeader = $request->getHeaderLine(
            $config->authenticatorHeader ?? 'Authorization'
        );

        if (strpos($tokenHeader, 'Bearer') === 0) {
            return trim(substr($tokenHeader, 6));
        }

        return $tokenHeader;
    }

    /**
     * We don't have anything to do here.
     *
     * @param Response|ResponseInterface $response
     * @param array|null                 $arguments
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null): void
    {
    }

    abstract protected function isAuthorized(User $user, $arguments): bool;
}
