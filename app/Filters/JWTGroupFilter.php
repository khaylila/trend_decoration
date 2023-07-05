<?php

declare(strict_types=1);

namespace App\Filters;

use CodeIgniter\Shield\Entities\User;

/**
 * Permission Authorization Filter.
 */
class JWTGroupFilter extends JWTAuthFilter
{
    protected function isAuthorized(User $user, $arguments): bool
    {
        return $user->inGroup(...$arguments);
    }
}
