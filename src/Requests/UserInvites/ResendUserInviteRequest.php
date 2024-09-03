<?php

declare(strict_types=1);

namespace PhpClient\Tailscale\Requests\UserInvites;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Resend a user invite.
 *
 * Resend a user invite by email. You can only use this if the specified invite was originally created with
 * an email specified.
 *
 * Note: Invite resends are rate limited to one per minute.
 *
 * @see  https://tailscale.com/api#tag/userinvites/POST/user-invites/%7BuserInviteId%7D/resend  Documentation
 * @version Relevant for 2024-09-03, API v2, OAS 3.1.0
 */
final class ResendUserInviteRequest extends Request
{
    protected Method $method = Method::POST;

    /**
     * @param  string  $userInviteId  ID of the user invite.
     */
    public function __construct(
        public string $userInviteId,
    ) {}

    public function resolveEndpoint(): string
    {
        return "/user-invites/$this->userInviteId/resend";
    }
}
