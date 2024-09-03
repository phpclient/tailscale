<?php

declare(strict_types=1);

namespace PhpClient\Tailscale\Requests\Webhooks;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Delete webhook.
 *
 * Delete a specific webhook.
 *
 * @see  https://tailscale.com/api#tag/webhooks/DELETE/webhooks/%7BendpointId%7D  Documentaion
 * @versuib Relevant for 2024-09-03, API v2, OAS 3.1.0
 */
final class DeleteWebhookRequest extends Request
{
    protected Method $method = Method::DELETE;

    /**
     * @param  string  $endpointId  ID for the webhook endpoint.
     */
    public function __construct(
        public readonly string $endpointId,
    ) {}

    public function resolveEndpoint(): string
    {
        return "/webhooks/$this->endpointId";
    }
}

