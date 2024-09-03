<?php

declare(strict_types=1);

namespace PhpClient\Tailscale\Requests\Devices;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Expire a device's key.
 *
 * Mark a device's node key as expired.
 * This will require the device to re-authenticate in order to connect to the tailnet.
 * The device must belong to the requesting user's tailnet.
 *
 * @see https://tailscale.com/api#tag/devices/POST/device/%7BdeviceId%7D/expire  Documentation
 * @version Relevant for 2024-09-01, API v2, OAS 3.1.0
 */
final class ExpireDeviceKeyRequest extends Request
{
    protected Method $method = Method::POST;

    /**
     * @param  string  $deviceId  ID of the device.
     * Using the device's nodeId is preferred, but its numeric id value can also be used.
     */
    public function __construct(
        private readonly string $deviceId,
    ) {}

    public function resolveEndpoint(): string
    {
        return "/device/$this->deviceId/expire";
    }
}
