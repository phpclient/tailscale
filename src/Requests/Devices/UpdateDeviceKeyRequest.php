<?php

declare(strict_types=1);

namespace PhpClient\Tailscale\Requests\Devices;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * Update device key/
 *
 * When a device is added to a tailnet, its key expiry is set according to the tailnet's key expiry setting.
 * If the key is not refreshed and expires, the device can no longer communicate with other devices in the tailnet.
 *
 * @see https://tailscale.com/api#tag/devices/POST/device/%7BdeviceId%7D/key  Documentation
 * @version Relevant for 2024-09-01, API v2, OAS 3.1.0
 */
final class UpdateDeviceKeyRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    /**
     * @param  string  $deviceId  ID of the device.
     * Using the device's nodeId is preferred, but its numeric id value can also be used.
     *
     * @param  array{
     *     keyExpiryDisabled: bool,
     * }  $data  Data for json body.
     */
    public function __construct(
        private readonly string $deviceId,
        private readonly array $data,
    ) {}

    public function resolveEndpoint(): string
    {
        return "/device/$this->deviceId/key";
    }

    protected function defaultBody(): array
    {
        return $this->data;
    }
}
