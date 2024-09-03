<?php

declare(strict_types=1);

namespace PhpClient\Tailscale\Requests\DeviceInvites;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * Create new share invites for a device.
 *
 * @see https://tailscale.com/api#tag/deviceinvites/POST/device/%7BdeviceId%7D/device-invites  Documentation
 * @version Relevant for 2024-08-31, API v2, OAS 3.1.0
 */
final class CreateDeviceInvitesRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    /**
     * @param  string  $deviceId  ID of the device.
     * Using the device's nodeId is preferred, but its numeric id value can also be used.
     *
     * @param  array{
     *     multiUse: bool,
     *     allowExitNode: bool,
     *     email: string,
     * }  $data  Data for json body
     */
    public function __construct(
        private readonly string $deviceId,
        private readonly array $data,
    ) {}

    public function resolveEndpoint(): string
    {
        return "/device/$this->deviceId/device-invites";
    }

    protected function defaultBody(): array
    {
        return $this->data;
    }
}
