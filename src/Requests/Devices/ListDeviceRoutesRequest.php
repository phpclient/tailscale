<?php

declare(strict_types=1);

namespace PhpClient\Tailscale\Requests\Devices;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * List device routes.
 *
 * Retrieve the list of subnet routes that a device is advertising, as well as those that are enabled for it.
 *
 * @see https://tailscale.com/api#tag/devices/GET/device/%7BdeviceId%7D/routes  Documentation
 * @version Relevant for 2023-09-01, API v2, OAS 3.1.0
 */
final class ListDeviceRoutesRequest extends Request
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
        return "/device/$this->deviceId/routes";
    }
}
