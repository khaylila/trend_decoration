<?php

declare(strict_types=1);

namespace App\Filters;

use CodeIgniter\Shield\Entities\User;

/**
 * Permission Authorization Filter.
 */
class JWTPermissionFilter extends JWTAuthFilter
{
    protected function isAuthorized(User $user, $arguments): bool
    {
        foreach ($arguments as $permission) {
            if ($user->can($permission)) {
                return true;
            }
        }

        return false;
    }
}
