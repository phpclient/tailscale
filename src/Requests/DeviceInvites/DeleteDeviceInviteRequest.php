<?php

declare(strict_types=1);

namespace PhpClient\Tailscale\Requests\DeviceInvites;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Delete a specific device invite.
 *
 * @see https://tailscale.com/api#tag/deviceinvites/DELETE/device-invites/%7BdeviceInviteId%7D  Documentation
 * @version Relevant for 2024-08-31, API v2, OAS 3.1.0
 */
final class DeleteDeviceInviteRequest extends Request
{
    protected Method $method = Method::DELETE;

    /**
     * @param string $deviceInviteId ID of the device invite.
     */
    public function __construct(
        private readonly string $deviceInviteId,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return "/device-invites/$this->deviceInviteId";
    }
}
