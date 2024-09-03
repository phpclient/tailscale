<?php

declare(strict_types=1);

namespace PhpClient\Tailscale\Resources;

use PhpClient\Tailscale\Requests\TailnetSettings\GetTailnetSettingsRequest;
use PhpClient\Tailscale\Requests\TailnetSettings\UpdateTailnetSettingsRequest;
use Saloon\Exceptions\Request\FatalRequestException;
use Saloon\Exceptions\Request\RequestException;
use Saloon\Http\BaseResource;
use Saloon\Http\Response;

/**
 * @see https://tailscale.com/api#tag/tailnetsettings  Documentation
 */
final class TailnetSettingsResource extends BaseResource
{
    /**
     * Get tailnet settings.
     *
     * Retrieve the settings for a specific tailnet.
     *
     * @param  string  $tailnet  The tailnet organization name.
     *
     *  When specifying a tailnet in the API, you can:
     *  - Provide a dash (-) to reference the default tailnet of the access token being used to make the API call.
     *  This is the best option for most users.
     *  - Provide the organization name found on the General Settings page of the Tailscale admin console.
     *
     * @throws FatalRequestException|RequestException
     *
     * @see https://tailscale.com/api#tag/tailnetsettings/GET/tailnet/%7Btailnet%7D/settings  Documentation
     * @version Relevant for 2024-08-30, API v2, OAS 3.1.0
     */
    public function getTailnetSettings(string $tailnet): Response
    {
        return $this->connector->send(
            request: new GetTailnetSettingsRequest(
                tailnet: $tailnet,
            ),
        );
    }

    /**
     * Update tailnet settings.
     *
     * Update the settings for a specific tailnet.
     *
     * @param  string  $tailnet  The tailnet organization name.
     *
     *   When specifying a tailnet in the API, you can:
     *   - Provide a dash (-) to reference the default tailnet of the access token being used to make the API call.
     *   This is the best option for most users.
     *   - Provide the organization name found on the General Settings page of the Tailscale admin console.
     *
     * @param  array{
     *     devicesApprovalOn: bool,
     *     devicesAutoUpdatesOn: bool,
     *     devicesKeyDurationDays: int,
     *     usersApprovalOn: bool,
     *     usersRoleAllowedToJoinExternalTailnets: string,
     *     networkFlowLoggingOn: bool,
     *     regionalRoutingOn: bool,
     *     postureIdentityCollectionOn: bool,
     * }  $data  Data for json body.
     * Settings for a tailnet.
     *
     * @throws FatalRequestException|RequestException
     *
     * @see https://tailscale.com/api#tag/tailnetsettings/PATCH/tailnet/%7Btailnet%7D/settings  Documentation
     * @version Relevant for 2024-08-30, API v2, OAS 3.1.0
     */
    public function updateTailnetSettings(string $tailnet, array $data): Response
    {
        return $this->connector->send(
            request: new UpdateTailnetSettingsRequest(
                tailnet: $tailnet,
                data: $data,
            ),
        );
    }
}
