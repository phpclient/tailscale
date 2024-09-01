<?php

declare(strict_types=1);

namespace PhpClient\Tailscale\Requests\Devices;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * Set device tags.
 *
 * Tags let you assign an identity to a device that is separate from human users, and use that identity as part of
 * an ACL to restrict access. Tags are similar to role accounts, but more flexible.
 *
 * Tags are created in the tailnet policy file by defining the tag and an owner of the tag. Once a device is tagged,
 * the tag is the owner of that device. A single node can have multiple tags assigned.
 *
 * Consult the policy file for your tailnet in the admin console for the list of tags that have been created for
 * your tailnet.
 *
 * @see https://tailscale.com/api#tag/devices/POST/device/%7BdeviceId%7D/tags  Documentation
 * @version Relevant for 2023-09-01, API v2, OAS 3.1.0
 */
final class SetDeviceTagsRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    /**
     * @param string $deviceId ID of the device.
     * Using the device's nodeId is preferred, but its numeric id value can also be used.
     *
     * @param array{
     *     tags: string[],
     * } $data Data for json body.
     */
    public function __construct(
        private readonly string $deviceId,
        private readonly array $data,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return "/device/$this->deviceId/tags";
    }

    protected function defaultBody(): array
    {
        return $this->data;
    }
}
