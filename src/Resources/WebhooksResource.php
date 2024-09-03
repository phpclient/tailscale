<?php

declare(strict_types=1);

namespace PhpClient\Tailscale\Resources;

use PhpClient\Tailscale\Requests\Webhooks\CreateWebhookRequest;
use PhpClient\Tailscale\Requests\Webhooks\DeleteWebhookRequest;
use PhpClient\Tailscale\Requests\Webhooks\GetWebhookRequest;
use PhpClient\Tailscale\Requests\Webhooks\ListWebhooksRequest;
use PhpClient\Tailscale\Requests\Webhooks\RotateWebhookSecretRequest;
use PhpClient\Tailscale\Requests\Webhooks\TestWebhookRequest;
use PhpClient\Tailscale\Requests\Webhooks\UpdateWebhookRequest;
use Saloon\Exceptions\Request\FatalRequestException;
use Saloon\Exceptions\Request\RequestException;
use Saloon\Http\BaseResource;
use Saloon\Http\Response;

/**
 * @see https://tailscale.com/api#tag/webhooks  Documentation
 */
final class WebhooksResource extends BaseResource
{
    /**
     * List webhooks
     *
     * List all webhooks for a tailnet.
     *
     * @param  string  $tailnet  The tailnet organization name.
     *
     *   When specifying a tailnet in the API, you can:
     *   - Provide a dash (-) to reference the default tailnet of the access token being used to make the API call.
     *   This is the best option for most users.
     *   - Provide the organization name found on the General Settings page of the Tailscale admin console.
     *
     * @throws FatalRequestException|RequestException
     *
     * @see  https://tailscale.com/api#tag/webhooks/GET/tailnet/%7Btailnet%7D/webhooks  Documentaion
     * @versuib Relevant for 2024-09-03, API v2, OAS 3.1.0
     */
    public function listWebhooks(string $tailnet): Response
    {
        return $this->connector->send(
            request: new ListWebhooksRequest(
                tailnet: $tailnet,
            ),
        );
    }


    /**
     * Create a webhook.
     *
     * Create a webhook within a tailnet.
     *
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
     *
     * @throws FatalRequestException|RequestException
     *
     * @see  https://tailscale.com/api#tag/webhooks/POST/tailnet/%7Btailnet%7D/webhooks  Documentaion
     * @versuib Relevant for 2024-09-03, API v2, OAS 3.1.0
     */
    public function createWebhook(string $tailnet, array $data): Response
    {
        return $this->connector->send(
            request: new CreateWebhookRequest(
                tailnet: $tailnet,
                data: $data,
            ),
        );
    }

    /**
     * Get webhook.
     *
     * Retrieve a specific webhook.
     *
     * @param  string  $endpointId  ID for the webhook endpoint.
     *
     * @throws FatalRequestException|RequestException
     *
     * @see  https://tailscale.com/api#tag/webhooks/GET/webhooks/%7BendpointId%7D  Documentaion
     * @versuib Relevant for 2024-09-03, API v2, OAS 3.1.0
     */
    public function getWebhook(string $endpointId): Response
    {
        return $this->connector->send(
            request: new GetWebhookRequest(
                endpointId: $endpointId,
            ),
        );
    }

    /**
     * Update webhook.
     *
     * Update a specific webhook.
     *
     * @param  string  $endpointId  ID for the webhook endpoint.
     *
     * @param  array{
     *    subscriptions: string[]
     * }  $data  Data for json body.
     *
     * @throws FatalRequestException|RequestException
     *
     * @see  https://tailscale.com/api#tag/webhooks/PATCH/webhooks/%7BendpointId%7D  Documentaion
     * @versuib Relevant for 2024-09-03, API v2, OAS 3.1.0
     */
    public function updateWebhook(string $endpointId, array $data): Response
    {
        return $this->connector->send(
            request: new UpdateWebhookRequest(
                endpointId: $endpointId,
                data: $data,
            ),
        );
    }

    /**
     * Delete webhook.
     *
     * Delete a specific webhook.
     *
     * @param  string  $endpointId  ID for the webhook endpoint.
     *
     * @throws FatalRequestException|RequestException
     *
     * @see  https://tailscale.com/api#tag/webhooks/DELETE/webhooks/%7BendpointId%7D  Documentaion
     * @versuib Relevant for 2024-09-03, API v2, OAS 3.1.0
     */
    public function deleteWebhook(string $endpointId): Response
    {
        return $this->connector->send(
            request: new DeleteWebhookRequest(
                endpointId: $endpointId,
            ),
        );
    }

    /**
     * Test a webhook.
     *
     * Test a specific webhook by sending out a test event to the endpoint URL.
     * This endpoint queues the event which is sent out asynchronously.
     *
     * If your webhook is configured correctly, within a few seconds your webhook endpoint should receive an event
     * with type of "test"
     *
     * @param  string  $endpointId  ID for the webhook endpoint.
     *
     * @throws FatalRequestException|RequestException
     *
     * @see  https://tailscale.com/api#tag/webhooks/POST/webhooks/%7BendpointId%7D/test  Documentaion
     * @versuib Relevant for 2024-09-03, API v2, OAS 3.1.0
     */
    public function testWebhook(string $endpointId): Response
    {
        return $this->connector->send(
            request: new TestWebhookRequest(
                endpointId: $endpointId,
            ),
        );
    }

    /**
     * Rotate webhook secret.
     *
     * Rotate and generate a new secret for a specific webhook.
     * This secret is used for generating the `Tailscale-Webhook-Signature` header in requests sent to the endpoint URL.
     *
     * @param  string  $endpointId  ID for the webhook endpoint.
     *
     * @throws FatalRequestException|RequestException
     *
     * @see  https://tailscale.com/api#tag/webhooks/POST/webhooks/%7BendpointId%7D/rotate  Documentaion
     * @versuib Relevant for 2024-09-03, API v2, OAS 3.1.0
     */
    public function rotateWebhookSecret(string $endpointId): Response
    {
        return $this->connector->send(
            request: new RotateWebhookSecretRequest(
                endpointId: $endpointId,
            ),
        );
    }
}
