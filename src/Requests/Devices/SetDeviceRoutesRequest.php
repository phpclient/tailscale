<?php

declare(strict_types=1);

namespace PhpClient\Tailscale\Requests\Devices;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * Set device routes.
 *
 * Set a device's enabled subnet routes by replacing the existing list of subnet routes with the supplied parameters.
 * Advertised routes cannot be set through the API, since they must be set directly on the device.
 *
 * @see https://tailscale.com/api#tag/devices/POST/device/%7BdeviceId%7D/routes  Documentation
 * @version Relevant for 2023-09-01, API v2, OAS 3.1.0
 */
final class SetDeviceRoutesRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    /**
     * @param string $deviceId ID of the device.
     * Using the device's nodeId is preferred, but its numeric id value can also be used.
     *
     * @param array{
     *     routes: string[],
     * } $data Data for json body.
     */
    public function __construct(
        private readonly string $deviceId,
        private readonly array $data,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return "/device/$this->deviceId/routes";
    }

    protected function defaultBody(): array
    {
        return $this->data;
    }
}
