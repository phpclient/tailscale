<?php

declare(strict_types=1);

namespace PhpClient\Tailscale\Requests\Webhooks;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * Update webhook.
 *
 * Update a specific webhook.
 *
 * @see  https://tailscale.com/api#tag/webhooks/PATCH/webhooks/%7BendpointId%7D  Documentaion
 * @versuib Relevant for 2024-09-03, API v2, OAS 3.1.0
 */
final class UpdateWebhookRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::PATCH;

    /**
     * @param  string  $endpointId  ID for the webhook endpoint.
     *
     * @param  array{
     *    subscriptions: string[]
     * }  $data  Data for json body.
     */
    public function __construct(
        public readonly string $endpointId,
        public readonly array $data,
    ) {}

    public function resolveEndpoint(): string
    {
        return "/webhooks/$this->endpointId";
    }

    public function defaultBody(): array
    {
        return $this->data;
    }
}
