<?php

declare(strict_types=1);

namespace PhpClient\Tailscale\Requests\DeviceInvites;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Resend a device invite by email.
 *
 * You can only use this if the specified invite was originally created with an email specified.
 *
 * @see https://tailscale.com/api#tag/deviceinvites/POST/device-invites/%7BdeviceInviteId%7D/resend  Documentation
 * @version Relevant for 2024-08-31, API v2, OAS 3.1.0
 */
final class ResendDeviceInviteRequest extends Request
{
    protected Method $method = Method::POST;

    /**
     * @param  string  $deviceInviteId  ID of the device invite.
     */
    public function __construct(
        private readonly string $deviceInviteId,
    ) {}

    public function resolveEndpoint(): string
    {
        return "/device-invites/$this->deviceInviteId/resend";
    }
}
