<?php

declare(strict_types=1);

namespace PhpClient\Tailscale\Requests\Webhooks;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Rotate webhook secret.
 *
 * Rotate and generate a new secret for a specific webhook.
 * This secret is used for generating the `Tailscale-Webhook-Signature` header in requests sent to the endpoint URL.
 *
 * @see  https://tailscale.com/api#tag/webhooks/POST/webhooks/%7BendpointId%7D/rotate  Documentaion
 * @versuib Relevant for 2024-09-03, API v2, OAS 3.1.0
 */
final class RotateWebhookSecretRequest extends Request
{
    protected Method $method = Method::POST;

    /**
     * @param  string  $endpointId  ID for the webhook endpoint.
     */
    public function __construct(
        public readonly string $endpointId,
    ) {}

    public function resolveEndpoint(): string
    {
        return "/webhooks/$this->endpointId/rotate";
    }
}