<?php

declare(strict_types=1);

namespace PhpClient\Tailscale\Requests\DeviceInvites;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * List all share invites for a device.
 *
 * @see https://tailscale.com/api#tag/deviceinvites/GET/device/%7BdeviceId%7D/device-invites  Documentation
 * @version Relevant for 2024-08-31, API v2, OAS 3.1.0
 */
final class ListAllShareInvitesForDeviceRequest extends Request
{
    protected Method $method = Method::GET;

    /**
     * @param string $deviceId ID of the device.
     * Using the device's nodeId is preferred, but its numeric id value can also be used.
     */
    public function __construct(
        private readonly string $deviceId,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return "/device/$this->deviceId/device-invites";
    }
}
