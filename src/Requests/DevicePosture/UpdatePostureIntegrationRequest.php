<?php

declare(strict_types=1);

namespace PhpClient\Tailscale\Requests\DevicePosture;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * Update a posture integration
 *
 * You may omit the clientSecret from your request to retain the previously configured clientSecret.
 *
 * @see https://tailscale.com/api#tag/deviceposture/PATCH/posture/integrations/%7Bid%7D  Documentation
 * @version Relevant for 2024-09-01, API v2, OAS 3.1.0
 */
final class UpdatePostureIntegrationRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::PATCH;

    /**
     * @param  string  $id  Unique identifier for a posture integration.
     *
     * @param  array{
     *     cloudId: string,
     *     clientId: string,
     *     tenantId: string,
     *     clientSecre?: string,
     * }  $data  Data for json body.
     */
    public function __construct(
        private readonly string $id,
        private readonly array $data,
    ) {}

    public function resolveEndpoint(): string
    {
        return "/posture/integrations/$this->id";
    }

    protected function defaultBody(): array
    {
        return $this->data;
    }
}
