<?php

declare(strict_types=1);

namespace PhpClient\Tailscale\Requests\Devices;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * Authorize device.
 *
 * This call marks a device as authorized or revokes its authorization for tailnets where device authorization
 * is required, according to the authorized field in the payload.
 *
 * @see https://tailscale.com/api#tag/devices/POST/device/%7BdeviceId%7D/authorized  Documentation
 * @version Relevant for 2023-09-01, API v2, OAS 3.1.0
 */
final class AuthorizeDeviceRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    /**
     * @param string $deviceId ID of the device.
     * Using the device's nodeId is preferred, but its numeric id value can also be used.
     *
     * @param array{
     *     authorized: bool,
     * } $data Data for json body.
     */
    public function __construct(
        private readonly string $deviceId,
        private readonly array $data,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return "/device/$this->deviceId/authorized";
    }

    protected function defaultBody(): array
    {
        return $this->data;
    }
}
