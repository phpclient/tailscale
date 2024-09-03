<?php

declare(strict_types=1);

namespace PhpClient\Tailscale\Requests\UserInvites;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Get a user invite.
 *
 * Retrieve a specific user invite.
 *
 * @see  https://tailscale.com/api#tag/userinvites/GET/user-invites/%7BuserInviteId%7D  Documentation
 * @version Relevant for 2024-09-03, API v2, OAS 3.1.0
 */
final class GetUserInviteRequest extends Request
{
    protected Method $method = Method::GET;

    /**
     * @param  string  $userInviteId  ID of the user invite.
     */
    public function __construct(
        public string $userInviteId,
    ) {}

    public function resolveEndpoint(): string
    {
        return "/user-invites/$this->userInviteId";
    }
}
