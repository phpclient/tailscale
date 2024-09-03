<?php

declare(strict_types=1);

namespace PhpClient\Tailscale\Requests\Devices;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * Set device name.
 *
 * When a device is added to a tailnet, its Tailscale device name (also sometimes referred to as machine name)
 * is generated from its OS hostname. The device name is the canonical name for the device on your tailnet.
 *
 * Device name changes immediately get propogated through your tailnet, so be aware that any existing Magic DNS URLs
 * using the old name will no longer work.
 *
 * @see https://tailscale.com/api#tag/devices/POST/device/%7BdeviceId%7D/name  Documentation
 * @version Relevant for 2024-09-01, API v2, OAS 3.1.0
 */
final class SetDeviceNameRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    /**
     * @param  string  $deviceId  ID of the device.
     * Using the device's nodeId is preferred, but its numeric id value can also be used.
     *
     * @param  array{
     *     name: bool,
     * }  $data  Data for json body.
     */
    public function __construct(
        private readonly string $deviceId,
        private readonly array $data,
    ) {}

    public function resolveEndpoint(): string
    {
        return "/device/$this->deviceId/name";
    }

    protected function defaultBody(): array
    {
        return $this->data;
    }
}
