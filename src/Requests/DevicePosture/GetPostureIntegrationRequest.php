<?php

declare(strict_types=1);

namespace PhpClient\Tailscale\Requests\DevicePosture;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Gets the posture integration.
 *
 * @see https://tailscale.com/api#tag/deviceposture/GET/posture/integrations/%7Bid%7D  Documentation
 * @version Relevant for 2024-09-01, API v2, OAS 3.1.0
 */
final class GetPostureIntegrationRequest extends Request
{
    protected Method $method = Method::GET;

    /**
     * @param string $id Unique identifier for a posture integration.
     */
    public function __construct(
        private readonly string $id,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return "/posture/integrations/$this->id";
    }
}

