<?php

declare(strict_types=1);

namespace PhpClient\Tailscale\Requests\DeviceInvites;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * Accepts the invitation to share a device into the requesting user's tailnet.
 *
 * Note that device invites cannot be accepted using an API access token generated from an OAuth client as
 * the shared device is scoped to a user.
 *
 * @see https://tailscale.com/api#tag/deviceinvites/POST/device-invites/-/accept  Documentation
 * @version Relevant for 2024-08-31, API v2, OAS 3.1.0
 */
final class AcceptDeviceInviteRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    /**
     * @param array{
     *     invite: string,
     * } $data Data for json body
     */
    public function __construct(
        private readonly array $data,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return "/device-invites/-/accept";
    }

    protected function defaultBody(): array
    {
        return $this->data;
    }
}
