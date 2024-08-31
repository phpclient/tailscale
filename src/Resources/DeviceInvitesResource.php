<?php

declare(strict_types=1);

namespace PhpClient\Tailscale\Resources;

use PhpClient\Tailscale\Requests\DeviceInvites\AcceptDeviceInviteRequest;
use PhpClient\Tailscale\Requests\DeviceInvites\CreateDeviceInvitesRequest;
use PhpClient\Tailscale\Requests\DeviceInvites\DeleteDeviceInviteRequest;
use PhpClient\Tailscale\Requests\DeviceInvites\GetDeviceInviteRequest;
use PhpClient\Tailscale\Requests\DeviceInvites\ListAllShareInvitesForDeviceRequest;
use PhpClient\Tailscale\Requests\DeviceInvites\ResendDeviceInviteRequest;
use Saloon\Exceptions\Request\FatalRequestException;
use Saloon\Exceptions\Request\RequestException;
use Saloon\Http\BaseResource;
use Saloon\Http\Response;

/**
 * @see https://tailscale.com/api#tag/deviceinvites  Documentation
 */
final class DeviceInvitesResource extends BaseResource
{
    /**
     * List all share invites for a device.
     *
     * @param string $deviceId ID of the device.
     * Using the device's nodeId is preferred, but its numeric id value can also be used.
     *
     * @throws FatalRequestException|RequestException
     *
     * @see https://tailscale.com/api#tag/deviceinvites/GET/device/%7BdeviceId%7D/device-invites  Documentation
     * @version Relevant for 2024-08-31, API v2, OAS 3.1.0
     */
    public function listDeviceInvites(string $deviceId): Response
    {
        return $this->connector->send(
            request: new ListAllShareInvitesForDeviceRequest(
                deviceId: $deviceId,
            ),
        );
    }

    /**
     * Create new share invites for a device.
     *
     * @param string $deviceId ID of the device.
     * Using the device's nodeId is preferred, but its numeric id value can also be used.
     *
     * @param array{
     * multiUse: bool,
     * allowExitNode: bool,
     * email: string,
     * } $data Data for json body
     *
     * @throws FatalRequestException|RequestException
     *
     * @see https://tailscale.com/api#tag/deviceinvites/POST/device/%7BdeviceId%7D/device-invites  Documentation
     * @version Relevant for 2024-08-31, API v2, OAS 3.1.0
     */
    public function createDeviceInvites(string $deviceId, array $data): Response
    {
        return $this->connector->send(
            request: new CreateDeviceInvitesRequest(
                deviceId: $deviceId,
                data: $data,
            ),
        );
    }

    /**
     * Retrieve a specific device invite.
     *
     * @param string $deviceInviteId ID of the device invite.
     *
     * @throws FatalRequestException|RequestException
     *
     * @see https://tailscale.com/api#tag/deviceinvites/GET/device-invites/%7BdeviceInviteId%7D  Documentation
     * @version Relevant for 2024-08-31, API v2, OAS 3.1.0
     */
    public function getDeviceInvite(string $deviceInviteId): Response
    {
        return $this->connector->send(
            request: new GetDeviceInviteRequest(
                deviceInviteId: $deviceInviteId,
            ),
        );
    }

    /**
     * Delete a specific device invite.
     *
     * @param string $deviceInviteId ID of the device invite.
     *
     * @throws FatalRequestException|RequestException
     *
     * @see https://tailscale.com/api#tag/deviceinvites/DELETE/device-invites/%7BdeviceInviteId%7D  Documentation
     * @version Relevant for 2024-08-31, API v2, OAS 3.1.0
     */
    public function deleteDeviceInvite(string $deviceInviteId): Response
    {
        return $this->connector->send(
            request: new DeleteDeviceInviteRequest(
                deviceInviteId: $deviceInviteId,
            ),
        );
    }

    /**
     * Resend a device invite by email.
     *
     * You can only use this if the specified invite was originally created with an email specified.
     *
     * @param string $deviceInviteId ID of the device invite.
     *
     * @throws FatalRequestException|RequestException
     *
     * @see https://tailscale.com/api#tag/deviceinvites/POST/device-invites/%7BdeviceInviteId%7D/resend  Documentation
     * @version Relevant for 2024-08-31, API v2, OAS 3.1.0
     */
    public function resendDeviceInvite(string $deviceInviteId): Response
    {
        return $this->connector->send(
            request: new ResendDeviceInviteRequest(
                deviceInviteId: $deviceInviteId,
            ),
        );
    }

    /**
     * Accepts the invitation to share a device into the requesting user's tailnet.
     *
     * Note that device invites cannot be accepted using an API access token generated from an OAuth client as
     * the shared device is scoped to a user.
     *
     * @param array{
     *     invite: string,
     * } $data Data for json body
     *
     * @throws FatalRequestException|RequestException
     *
     * @see https://tailscale.com/api#tag/deviceinvites/POST/device-invites/-/accept  Documentation
     * @version Relevant for 2024-08-31, API v2, OAS 3.1.0
     */
    public function acceptDeviceInvite(array $data): Response
    {
        return $this->connector->send(
            request: new AcceptDeviceInviteRequest(
                data: $data,
            ),
        );
    }
}
