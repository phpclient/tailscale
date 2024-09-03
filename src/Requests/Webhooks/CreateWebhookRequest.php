<?php

declare(strict_types=1);

namespace PhpClient\Tailscale\Requests\Webhooks;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * Create a webhook.
 *
 * Create a webhook within a tailnet.
 *
 * @see  https://tailscale.com/api#tag/webhooks/POST/tailnet/%7Btailnet%7D/webhooks  Documentaion
 * @versuib Relevant for 2024-09-03, API v2, OAS 3.1.0
 */
final class CreateWebhookRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    /**
     * @param  string  $tailnet  The tailnet organization name.
     *
     *   When specifying a tailnet in the API, you can:
     *   - Provide a dash (-) to reference the default tailnet of the access token being used to make the API call.
     *   This is the best option for most users.
     *   - Provide the organization name found on the General Settings page of the Tailscale admin console.
     *
     * @param  array{
     *     endpointUrl: string,
     *     providerType?: string,
     *     subscriptions: string[]
     * }  $data  Data for json body.
     */
    public function __construct(
        public readonly string $tailnet,
        public readonly array $data,
    ) {}

    public function resolveEndpoint(): string
    {
        return "/tailnet/$this->tailnet/webhooks";
    }

    public function defaultBody(): array
    {
        return $this->data;
    }
}
