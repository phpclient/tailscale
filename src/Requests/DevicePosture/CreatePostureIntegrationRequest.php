<?php

declare(strict_types=1);

namespace PhpClient\Tailscale\Requests\DevicePosture;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * Create a posture integration.
 *
 * Must include provider and clientSecret.
 *
 * @see https://tailscale.com/api#tag/deviceposture/POST/tailnet/%7Btailnet%7D/posture/integrations  Documentation
 * @version Relevant for 2024-09-01, API v2, OAS 3.1.0
 */
final class CreatePostureIntegrationRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    /**
     * @param string $tailnet The tailnet organization name.
     *
     * When specifying a tailnet in the API, you can:
     * - Provide a dash (-) to reference the default tailnet of the access token being used to make the API call.
     * This is the best option for most users.
     * - Provide the organization name found on the General Settings page of the Tailscale admin console.
     *
     * @param array{
     *     provider: string,
     *     cloudId: string,
     *     clientId: string,
     *     tenantId: string,
     *     clientSecret: string,
     * } $data Data for json body.
     */
    public function __construct(
        private readonly string $tailnet,
        private readonly array $data,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return "/tailnet/$this->tailnet/posture/integrations";
    }

    protected function defaultBody(): array
    {
        return $this->data;
    }
}
