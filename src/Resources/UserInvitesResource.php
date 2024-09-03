<?php

declare(strict_types=1);

namespace PhpClient\Tailscale\Resources;

use PhpClient\Tailscale\Requests\UserInvites\CreateUserInvitesRequest;
use PhpClient\Tailscale\Requests\UserInvites\DeleteUserInviteRequest;
use PhpClient\Tailscale\Requests\UserInvites\GetUserInviteRequest;
use PhpClient\Tailscale\Requests\UserInvites\ListUserInvitesRequest;
use PhpClient\Tailscale\Requests\UserInvites\ResendUserInviteRequest;
use Saloon\Exceptions\Request\FatalRequestException;
use Saloon\Exceptions\Request\RequestException;
use Saloon\Http\BaseResource;
use Saloon\Http\Response;

/**
 * @see https://tailscale.com/api#tag/userinvites  Documentation
 */
final class UserInvitesResource extends BaseResource
{
    /**
     * List user invites.
     *
     * List all open (not yet accepted) user invites to the tailnet.
     *
     * @param  string  $tailnet  The tailnet organization name.
     *
     *  When specifying a tailnet in the API, you can:
     *  - Provide a dash (-) to reference the default tailnet of the access token being used to make the API call.
     *  This is the best option for most users.
     *  - Provide the organization name found on the General Settings page of the Tailscale admin console.
     *
     * @throws FatalRequestException|RequestException
     *
     * @see  https://tailscale.com/api#tag/userinvites/GET/tailnet/%7Btailnet%7D/user-invites  Documentation
     * @version Relevant for 2024-09-03, API v2, OAS 3.1.0
     */
    public function listUserInvites(string $tailnet): Response
    {
        return $this->connector->send(
            request: new ListUserInvitesRequest(
                tailnet: $tailnet,
            ),
        );
    }

    /**
     * Create user invites.
     *
     * Create, and optionally email out, new user invites to join the tailnet.
     *
     * @param  string  $tailnet  The tailnet organization name.
     *
     *  When specifying a tailnet in the API, you can:
     *  - Provide a dash (-) to reference the default tailnet of the access token being used to make the API call.
     *  This is the best option for most users.
     *  - Provide the organization name found on the General Settings page of the Tailscale admin console.
     *
     * @param  array{
     *     role: string,
     *     email: string,
     * }[]  $data  Data for json body.
     *
     * @throws FatalRequestException|RequestException
     *
     * @see  https://tailscale.com/api#tag/userinvites/POST/tailnet/%7Btailnet%7D/user-invites  Documentation
     * @version Relevant for 2024-09-03, API v2, OAS 3.1.0
     */
    public function createUserInvites(string $tailnet, array $data): Response
    {
        return $this->connector->send(
            request: new CreateUserInvitesRequest(
                tailnet: $tailnet,
                data: $data,
            ),
        );
    }

    /**
     * Get a user invite.
     *
     * Retrieve a specific user invite.
     *
     * @param  string  $userInviteId  ID of the user invite.
     *
     * @throws FatalRequestException|RequestException
     *
     * @see  https://tailscale.com/api#tag/userinvites/GET/user-invites/%7BuserInviteId%7D  Documentation
     * @version Relevant for 2024-09-03, API v2, OAS 3.1.0
     */
    public function getUserInvite(string $userInviteId): Response
    {
        return $this->connector->send(
            request: new GetUserInviteRequest(
                userInviteId: $userInviteId,
            ),
        );
    }

    /**
     * Delete a user invite.
     *
     * Deletes a specific user invite.
     *
     * @param  string  $userInviteId  ID of the user invite.
     *
     * @throws FatalRequestException|RequestException
     *
     * @see  https://tailscale.com/api#tag/userinvites/DELETE/user-invites/%7BuserInviteId%7D  Documentation
     * @version Relevant for 2024-09-03, API v2, OAS 3.1.0
     */
    public function deleteUserInvite(string $userInviteId): Response
    {
        return $this->connector->send(
            request: new DeleteUserInviteRequest(
                userInviteId: $userInviteId,
            ),
        );
    }

    /**
     * Resend a user invite.
     *
     * Resend a user invite by email. You can only use this if the specified invite was originally created with
     * an email specified.
     *
     * Note: Invite resends are rate limited to one per minute.
     *
     * @param  string  $userInviteId  ID of the user invite.
     *
     * @throws FatalRequestException|RequestException
     *
     * @see  https://tailscale.com/api#tag/userinvites/POST/user-invites/%7BuserInviteId%7D/resend  Documentation
     * @version Relevant for 2024-09-03, API v2, OAS 3.1.0
     */
    public function resendUserInvite(string $userInviteId): Response
    {
        return $this->connector->send(
            request: new ResendUserInviteRequest(
                userInviteId: $userInviteId,
            ),
        );
    }
}
