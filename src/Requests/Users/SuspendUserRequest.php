<?php

declare(strict_types=1);

namespace PhpClient\Tailscale\Requests\Users;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Suspend a user.
 *
 * Suspends a user from their tailnet.
 *
 * @see  https://tailscale.com/api#tag/users/POST/users/%7BuserId%7D/suspend  Documentaion
 * @version Relevant for 2024-09-03, API v2, OAS 3.1.0
 */
final class SuspendUserRequest extends Request
{
    protected Method $method = Method::POST;

    /**
     * @param  string  $userId  ID of the user.
     */
    public function __construct(
        private readonly string $userId,
    ) {}

    public function resolveEndpoint(): string
    {
        return "/users/$this->userId/suspend";
    }
}
