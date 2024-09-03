<?php

declare(strict_types=1);

namespace PhpClient\Tailscale\Requests\TailnetSettings;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * Update tailnet settings.
 *
 * Update the settings for a specific tailnet.
 *
 * @see https://tailscale.com/api#tag/tailnetsettings/PATCH/tailnet/%7Btailnet%7D/settings  Documentation
 * @version Relevant for 2024-08-30, API v2, OAS 3.1.0
 */
final class UpdateTailnetSettingsRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::PATCH;

    /**
     * @param  string  $tailnet  The tailnet organization name.
     *
     *    When specifying a tailnet in the API, you can:
     *    - Provide a dash (-) to reference the default tailnet of the access token being used to make the API call.
     *    This is the best option for most users.
     *    - Provide the organization name found on the General Settings page of the Tailscale admin console.
     *
     * @param  array{
     *      devicesApprovalOn: bool,
     *      devicesAutoUpdatesOn: bool,
     *      devicesKeyDurationDays: int,
     *      usersApprovalOn: bool,
     *      usersRoleAllowedToJoinExternalTailnets: string,
     *      networkFlowLoggingOn: bool,
     *      regionalRoutingOn: bool,
     *      postureIdentityCollectionOn: bool,
     *  }  $data  Data for json body.
     *  Settings for a tailnet.
     */
    public function __construct(
        public readonly string $tailnet,
        public readonly array $data,
    ) {}

    public function resolveEndpoint(): string
    {
        return "/tailnet/$this->tailnet/settings";
    }

    public function defaultBody(): array
    {
        return $this->data;
    }
}
