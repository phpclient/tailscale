<?php

declare(strict_types=1);

namespace PhpClient\Tailscale\Requests\Devices;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Delete a device.
 *
 * Deletes the device from its tailnet. The device must belong to the requesting user's tailnet.
 * Deleting devices shared with the tailnet is not supported.
 *
 * @see https://tailscale.com/api#tag/devices/DELETE/device/%7BdeviceId%7D  Documentation
 * @version Relevant for 2023-09-01, API v2, OAS 3.1.0
 */
final class DeleteDeviceRequest extends Request
{
    protected Method $method = Method::DELETE;

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
        return "/device/$this->deviceId";
    }
}
