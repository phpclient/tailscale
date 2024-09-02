<?php

declare(strict_types=1);

namespace PhpClient\Tailscale\Requests\Devices;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * Set device IPv4 address.
 *
 * When a device is added to a tailnet, its Tailscale IPv4 address is set at random either from the CGNAT range,
 * or a subset of the CGNAT range specified by an ip pool. This endpoint can be used to replace the existing IPv4
 * address with a specific value.
 *
 * This action will break any existing connections to this machine. You will need to reconnect to this machine using
 * the new IP address. You may also need to flush your DNS cache.
 *
 * @see https://tailscale.com/api#tag/devices/POST/device/%7BdeviceId%7D/ip  Documentation
 * @version Relevant for 2024-09-01, API v2, OAS 3.1.0
 */
final class SetDeviceIpV4AddressRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    /**
     * @param string $deviceId ID of the device.
     * Using the device's nodeId is preferred, but its numeric id value can also be used.
     *
     * @param array{
     *     ipv4: bool,
     * } $data Data for json body.
     */
    public function __construct(
        private readonly string $deviceId,
        private readonly array $data,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return "/device/$this->deviceId/ip";
    }

    protected function defaultBody(): array
    {
        return $this->data;
    }
}
