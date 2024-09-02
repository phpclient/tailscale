<?php

declare(strict_types=1);

namespace PhpClient\Tailscale\Requests\Devices;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Get device posture attributes.
 *
 * Retrieve all posture attributes for the specified device.
 * This returns a JSON object of all the key-value pairs of posture attributes for the device.
 *
 * @see https://tailscale.com/api#tag/devices/GET/device/%7BdeviceId%7D/attributes  Documentation
 * @version Relevant for 2024-09-01, API v2, OAS 3.1.0
 */
final class GetDevicePostureAttributesRequest extends Request
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
        return "/device/$this->deviceId/attributes";
    }
}
