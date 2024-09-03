<?php

declare(strict_types=1);

namespace PhpClient\Tailscale\Resources;

use PhpClient\Tailscale\Requests\Users\ApproveUserRequest;
use PhpClient\Tailscale\Requests\Users\DeleteUserRequest;
use PhpClient\Tailscale\Requests\Users\GetUserRequest;
use PhpClient\Tailscale\Requests\Users\ListUsersRequest;
use PhpClient\Tailscale\Requests\Users\RestoreUserRequest;
use PhpClient\Tailscale\Requests\Users\SuspendUserRequest;
use PhpClient\Tailscale\Requests\Users\UpdateUserRoleRequest;
use Saloon\Exceptions\Request\FatalRequestException;
use Saloon\Exceptions\Request\RequestException;
use Saloon\Http\BaseResource;
use Saloon\Http\Response;

/**
 * @see https://tailscale.com/api#tag/users  Documentation
 */
final class UsersResource extends BaseResource
{
    /**
     * List users.
     *
     * List all users of a tailnet.
     *
     * @param  string  $tailnet  The tailnet organization name.
     *
     *   When specifying a tailnet in the API, you can:
     *   - Provide a dash (-) to reference the default tailnet of the access token being used to make the API call.
     *   This is the best option for most users.
     *   - Provide the organization name found on the General Settings page of the Tailscale admin console.
     *
     * @param  string|null  $type  Allow for filtering the output by user type.
     *
     * @param  string|null  $role  Allow for filtering the output by user role.
     *
     * @throws FatalRequestException|RequestException
     *
     * @see  https://tailscale.com/api#tag/users/GET/tailnet/%7Btailnet%7D/users  Documentaion
     * @version Relevant for 2024-09-03, API v2, OAS 3.1.0
     */
    public function listUsers(string $tailnet, string $type = null, string $role = null): Response
    {
        return $this->connector->send(
            request: new ListUsersRequest(
                tailnet: $tailnet,
                type: $type,
                role: $role,
            ),
        );
    }

    /**
     * Get a user.
     *
     * Retrieve details about the specified user.
     *
     * @param  string  $userId  ID of the user.
     *
     * @throws FatalRequestException|RequestException
     *
     * @see  https://tailscale.com/api#tag/users/GET/users/%7BuserId%7D  Documentaion
     * @version Relevant for 2024-09-03, API v2, OAS 3.1.0
     */
    public function getUser(string $userId): Response
    {
        return $this->connector->send(
            request: new GetUserRequest(
                userId: $userId,
            ),
        );
    }

    /**
     * Update user role.
     *
     * Update the role for the specified user.
     *
     * @param  string  $userId  ID of the user.
     *
     * @param  array{
     *     role: string,
     * }  $data  Data for json body.
     *
     * @throws FatalRequestException|RequestException
     *
     * @see  https://tailscale.com/api#tag/users/POST/users/%7BuserId%7D/role  Documentaion
     * @version Relevant for 2024-09-03, API v2, OAS 3.1.0
     */
    public function updateUserRole(string $userId, array $data): Response
    {
        return $this->connector->send(
            request: new UpdateUserRoleRequest(
                userId: $userId,
                data: $data,
            ),
        );
    }

    /**
     * Approve a user.
     *
     * Approve a pending user's access to the tailnet. This is a no-op if user approval has not been enabled for
     * the tailnet, or if the user is already approved.
     *
     * User approval can be managed using the tailnet settings endpoints.
     *
     * @param  string  $userId  ID of the user.
     *
     * @throws FatalRequestException|RequestException
     *
     * @see  https://tailscale.com/api#tag/users/POST/users/%7BuserId%7D/approve  Documentaion
     * @version Relevant for 2024-09-03, API v2, OAS 3.1.0
     */
    public function approveUser(string $userId): Response
    {
        return $this->connector->send(
            request: new ApproveUserRequest(
                userId: $userId,
            ),
        );
    }

    /**
     * Suspend a user.
     *
     * Suspends a user from their tailnet.
     *
     * @param  string  $userId  ID of the user.
     *
     * @throws FatalRequestException|RequestException
     *
     * @see  https://tailscale.com/api#tag/users/POST/users/%7BuserId%7D/suspend  Documentaion
     * @version Relevant for 2024-09-03, API v2, OAS 3.1.0
     */
    public function suspendUser(string $userId): Response
    {
        return $this->connector->send(
            request: new SuspendUserRequest(
                userId: $userId,
            ),
        );
    }

    /**
     * Restore a user.
     *
     * Restores a suspended user's access to their tailnet.
     *
     * @param  string  $userId  ID of the user.
     *
     * @throws FatalRequestException|RequestException
     *
     * @see  https://tailscale.com/api#tag/users/POST/users/%7BuserId%7D/restore  Documentaion
     * @version Relevant for 2024-09-03, API v2, OAS 3.1.0
     */
    public function restoreUser(string $userId): Response
    {
        return $this->connector->send(
            request: new RestoreUserRequest(
                userId: $userId,
            ),
        );
    }

    /**
     * Delete a user.
     *
     * Delete a user from their tailnet.
     *
     * @param  string  $userId  ID of the user.
     *
     * @throws FatalRequestException|RequestException
     *
     * @see  https://tailscale.com/api#tag/users/POST/users/%7BuserId%7D/delete  Documentaion
     * @version Relevant for 2024-09-03, API v2, OAS 3.1.0
     */
    public function deleteUser(string $userId): Response
    {
        return $this->connector->send(
            request: new DeleteUserRequest(
                userId: $userId,
            ),
        );
    }
}
