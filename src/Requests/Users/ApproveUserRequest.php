<?php

declare(strict_types=1);

namespace PhpClient\Tailscale\Requests\Users;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Approve a user.
 *
 * Approve a pending user's access to the tailnet. This is a no-op if user approval has not been enabled for
 * the tailnet, or if the user is already approved.
 *
 * User approval can be managed using the tailnet settings endpoints.
 *
 * @see  https://tailscale.com/api#tag/users/POST/users/%7BuserId%7D/approve  Documentaion
 * @version Relevant for 2024-09-03, API v2, OAS 3.1.0
 */
final class ApproveUserRequest extends Request
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
        return "/users/$this->userId/approve";
    }
}
