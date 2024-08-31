<?php

declare(strict_types=1);

namespace PhpClient\Tailscale\Resources;

use PhpClient\Tailscale\Requests\DevicePosture\CreatePostureIntegrationRequest;
use PhpClient\Tailscale\Requests\DevicePosture\DeletePostureIntegrationRequest;
use PhpClient\Tailscale\Requests\DevicePosture\GetPostureIntegrationRequest;
use PhpClient\Tailscale\Requests\DevicePosture\ListAllPostureIntegrationsRequest;
use PhpClient\Tailscale\Requests\DevicePosture\UpdatePostureIntegrationRequest;
use Saloon\Exceptions\Request\FatalRequestException;
use Saloon\Exceptions\Request\RequestException;
use Saloon\Http\BaseResource;
use Saloon\Http\Response;

/**
 * @see https://tailscale.com/api#tag/deviceposture  Documentation
 */
final class DevicePostureResource extends BaseResource
{
    /**
     * List all the posture integrations for a tailnet.
     *
     * @param string $tailnet The tailnet organization name.
     *
     * When specifying a tailnet in the API, you can:
     * - Provide a dash (-) to reference the default tailnet of the access token being used to make the API call.
     * This is the best option for most users.
     * - Provide the organization name found on the General Settings page of the Tailscale admin console.
     *
     * @throws FatalRequestException|RequestException
     *
     * @see https://tailscale.com/api#tag/deviceposture/GET/tailnet/%7Btailnet%7D/posture/integrations  Documentation
     * @version Relevant for 2024-09-01, API v2, OAS 3.1.0
     */
    public function listAllPostureIntegrations(string $tailnet): Response
    {
        return $this->connector->send(
            request: new ListAllPostureIntegrationsRequest(
                tailnet: $tailnet,
            ),
        );
    }

    /**
     * Create a posture integration.
     *
     * Must include provider and clientSecret.
     *
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
     *
     * @throws FatalRequestException|RequestException
     *
     * @see https://tailscale.com/api#tag/deviceposture/POST/tailnet/%7Btailnet%7D/posture/integrations  Documentation
     * @version Relevant for 2024-09-01, API v2, OAS 3.1.0
     */
    public function createPostureIntegration(string $tailnet, array $data): Response
    {
        return $this->connector->send(
            request: new CreatePostureIntegrationRequest(
                tailnet: $tailnet,
                data: $data,
            ),
        );
    }

    /**
     * Get a posture integration.
     *
     * @param string $id Unique identifier for a posture integration.
     *
     * @throws FatalRequestException|RequestException
     *
     * @see https://tailscale.com/api#tag/deviceposture/GET/posture/integrations/%7Bid%7D  Documentation
     * @version Relevant for 2024-09-01, API v2, OAS 3.1.0
     */
    public function getPostureIntegration(string $id): Response
    {
        return $this->connector->send(
            request: new GetPostureIntegrationRequest(
                id: $id,
            ),
        );
    }

    /**
     * Update a posture integration
     *
     * You may omit the clientSecret from your request to retain the previously configured clientSecret.
     *
     * @param string $id Unique identifier for a posture integration.
     *
     * @param array{
     *     cloudId: string,
     *     clientId: string,
     *     tenantId: string,
     *     clientSecre?: string,
     * } $data Data for json body.
     *
     * @throws FatalRequestException|RequestException
     *
     * @see https://tailscale.com/api#tag/deviceposture/PATCH/posture/integrations/%7Bid%7D  Documentation
     * @version Relevant for 2024-09-01, API v2, OAS 3.1.0
     */
    public function updatePostureIntegration(string $id, array $data): Response
    {
        return $this->connector->send(
            request: new UpdatePostureIntegrationRequest(
                id: $id,
                data: $data,
            ),
        );
    }

    /**
     * Delete a specific posture integration.
     *
     * @param string $id Unique identifier for a posture integration.
     *
     * @throws FatalRequestException|RequestException
     *
     * @see https://tailscale.com/api#tag/deviceposture/DELETE/posture/integrations/%7Bid%7D  Documentation
     * @version Relevant for 2024-09-01, API v2, OAS 3.1.0
     */
    public function deletePostureIntegration(string $id): Response
    {
        return $this->connector->send(
            request: new DeletePostureIntegrationRequest(
                id: $id,
            ),
        );
    }
}
