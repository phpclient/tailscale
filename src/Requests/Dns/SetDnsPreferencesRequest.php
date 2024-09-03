<?php

declare(strict_types=1);

namespace PhpClient\Tailscale\Requests\Dns;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * Set DNS preferences
 *
 * Set the DNS preferences for a tailnet; specifically, the MagicDNS setting. Note that MagicDNS is dependent on
 * DNS servers. Learn about MagicDNS.
 *
 * If there is at least one DNS server, then MagicDNS can be enabled. Otherwise, it returns an error.
 *
 * Note that removing all nameservers will turn off MagicDNS. To reenable it, nameservers must be added back,
 * and MagicDNS must be explicitly turned on.
 *
 * @see https://tailscale.com/api#tag/dns/POST/tailnet/{tailnet}/dns/preferences  Documentaion
 * @version Relevant for 2024-09-03, API v2
 */
final class SetDnsPreferencesRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    /**
     * @param string $tailnet The tailnet organization name.
     *
     * When specifying a tailnet in the API, you can:
     * - Provide a dash (-) to reference the default tailnet of the access token being used to make
     * the API call.
     * This is the best option for most users.
     * - Provide the organization name found on the General Settings page of the Tailscale admin console.
     *
     * @param array{
     *     magicDNS: bool,
     * } $data Data for json body.
     *
     * Whether MagicDNS is active for this tailnet.
     */
    public function __construct(
        private readonly string $tailnet,
        private readonly array $data,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/tailnet/{tailnet}/dns/preferences';
    }
}
