<?php

declare(strict_types=1);

namespace Config;

use CodeIgniter\Shield\Config\AuthJWT as ShieldAuthJWT;

/**
 * JWT Authenticator Configuration
 */
class AuthJWT extends ShieldAuthJWT
{
    public array $defaultClaims = [
        'iss' => 'https://codeigniter.com/',
    ];

    public array $keys = [
        'default' => [
            // Symmetric Key
            [
                'kid' => '',      // Key ID. Optional if you have only one key.
                'alg' => 'HS256', // algorithm.
                // Set secret random string. Needs at least 256 bits for HS256 algorithm.
                // E.g., $ php -r 'echo base64_encode(random_bytes(32));'
                'secret' => 'k4Q0ZLTbQrNtWgmuLv351WeMIz+D4emCQMbBj6NNQPk=',
            ],
        ],
    ];

    public int $timeToLive = DAY; //second
}
