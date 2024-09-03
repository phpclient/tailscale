<?php

declare(strict_types=1);

namespace PhpClient\Tailscale\Requests\TailnetSettings;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Get tailnet settings.
 *
 * Retrieve the settings for a specific tailnet.
 *
 * @see https://tailscale.com/api#tag/tailnetsettings/GET/tailnet/%7Btailnet%7D/settings  Documentation
 * @version Relevant for 2024-08-30, API v2, OAS 3.1.0
 */
final class GetTailnetSettingsRequest extends Request
{
    protected Method $method = Method::GET;

    /**
     * @param  string  $tailnet  The tailnet organization name.
     *
     *  When specifying a tailnet in the API, you can:
     *  - Provide a dash (-) to reference the default tailnet of the access token being used to make the API call.
     *  This is the best option for most users.
     *  - Provide the organization name found on the General Settings page of the Tailscale admin console.
     */
    public function __construct(
        public readonly string $tailnet,
    ) {}

    public function resolveEndpoint(): string
    {
        return "/tailnet/$this->tailnet/settings";
    }
}