<?php

declare(strict_types=1);

namespace PhpClient\Tailscale\Requests\Webhooks;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Test a webhook.
 *
 * Test a specific webhook by sending out a test event to the endpoint URL.
 * This endpoint queues the event which is sent out asynchronously.
 *
 * If your webhook is configured correctly, within a few seconds your webhook endpoint should receive an event
 * with type of "test"
 *
 * @see  https://tailscale.com/api#tag/webhooks/POST/webhooks/%7BendpointId%7D/test  Documentaion
 * @versuib Relevant for 2024-09-03, API v2, OAS 3.1.0
 */
final class TestWebhookRequest extends Request
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
        return "/webhooks/{$this->endpointId}/test";
    }
}
