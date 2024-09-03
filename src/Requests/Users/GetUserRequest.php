<?php

declare(strict_types=1);

namespace PhpClient\Tailscale\Requests\Users;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Get a user.
 *
 * Retrieve details about the specified user.
 *
 * @see  https://tailscale.com/api#tag/users/GET/users/%7BuserId%7D  Documentaion
 * @version Relevant for 2024-09-03, API v2, OAS 3.1.0
 */
final class GetUserRequest extends Request
{
    protected Method $method = Method::GET;

    /**
     * @param  string  $userId  ID of the user.
     */
    public function __construct(
        private readonly string $userId,
    ) {}

    public function resolveEndpoint(): string
    {
        return "/users/$this->userId";
    }
}
