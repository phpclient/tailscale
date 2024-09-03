<?php

declare(strict_types=1);

namespace PhpClient\Tailscale\Requests\UserInvites;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Delete a user invite.
 *
 * Deletes a specific user invite.
 *
 * @see  https://tailscale.com/api#tag/userinvites/DELETE/user-invites/%7BuserInviteId%7D  Documentation
 * @version Relevant for 2024-09-03, API v2, OAS 3.1.0
 */
final class DeleteUserInviteRequest extends Request
{
    protected Method $method = Method::DELETE;

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
