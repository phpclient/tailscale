<?php

declare(strict_types=1);

namespace PhpClient\Tailscale\Resources;

use PhpClient\Tailscale\Requests\Dns\GetDnsPreferencesRequest;
use PhpClient\Tailscale\Requests\Dns\GetSplitDnsRequest;
use PhpClient\Tailscale\Requests\Dns\ListDnsNameserversRequest;
use PhpClient\Tailscale\Requests\Dns\ListDnsSearchPathsRequest;
use PhpClient\Tailscale\Requests\Dns\SetDnsNameserversRequest;
use PhpClient\Tailscale\Requests\Dns\SetDnsPreferencesRequest;
use PhpClient\Tailscale\Requests\Dns\SetDnsSearchPathsRequest;
use PhpClient\Tailscale\Requests\Dns\SetSplitDnsRequest;
use PhpClient\Tailscale\Requests\Dns\UpdateSplitDnsRequest;
use Saloon\Exceptions\Request\FatalRequestException;
use Saloon\Exceptions\Request\RequestException;
use Saloon\Http\BaseResource;
use Saloon\Http\Response;

/**
 * @see https://tailscale.com/api#tag/dns  Documentation
 */
final class DnsResource extends BaseResource
{
    /**
     * List DNS nameservers.
     *
     * Lists the global DNS nameservers for a tailnet.
     *
     * @param  string  $tailnet  The tailnet organization name.
     *
     * When specifying a tailnet in the API, you can:
     * - Provide a dash (-) to reference the default tailnet of the access token being used to make the API call.
     * This is the best option for most users.
     * - Provide the organization name found on the General Settings page of the Tailscale admin console.
     *
     * @throws FatalRequestException|RequestException
     *
     * @see https://tailscale.com/api#tag/dns/GET/tailnet/%7Btailnet%7D/dns/nameservers  Documentaion
     * @version Relevant for 2024-09-03, API v2, OAS 3.1.0
     */
    public function listDnsNameservers(string $tailnet): Response
    {
        return $this->connector->send(
            request: new ListDnsNameserversRequest(
                tailnet: $tailnet,
            ),
        );
    }

    /**
     * Set DNS nameservers
     *
     * Replaces the list of global DNS nameservers for the given tailnet with the list supplied in the request.
     *
     * Note that changing the list of DNS nameservers may also affect the status of MagicDNS (if MagicDNS is on; learn about
     * MagicDNS). If all nameservers have been removed, MagicDNS will be automatically disabled (until explicitly turned back
     * on by the user).
     *
     * @param  string  $tailnet  The tailnet organization name.
     *
     * When specifying a tailnet in the API, you can:
     * - Provide a dash (-) to reference the default tailnet of the access token being used to make the API call.
     * This is the best option for most users.
     * - Provide the organization name found on the General Settings page of the Tailscale admin console.
     *
     * @param  array{
     *     dns: string[],
     * }  $data  Data for json body.
     *
     * DNS nameservers.
     *
     * @throws FatalRequestException|RequestException
     *
     * @see https://tailscale.com/api#tag/dns/POST/tailnet/%7Btailnet%7D/dns/nameservers  Documentaion
     * @version Relevant for 2024-09-03, API v2, OAS 3.1.0
     */
    public function setDnsNameservers(string $tailnet, array $data): Response
    {
        return $this->connector->send(
            request: new SetDnsNameserversRequest(
                tailnet: $tailnet,
                data: $data,
            ),
        );
    }

    /**
     * Get DNS preferences.
     *
     * Retrieves the DNS preferences that are currently set for the given tailnet.
     *
     * @param  string  $tailnet  The tailnet organization name.
     *
     * When specifying a tailnet in the API, you can:
     * - Provide a dash (-) to reference the default tailnet of the access token being used to make the API call.
     *   This is the best option for most users.
     * - Provide the organization name found on the General Settings page of the Tailscale admin console.
     *
     * @throws FatalRequestException|RequestException
     *
     * @see https://tailscale.com/api#tag/dns/GET/tailnet/%7Btailnet%7D/dns/preferences  Documentaion
     * @version Relevant for 2024-09-03, API v2, OAS 3.1.0
     */
    public function getDnsPreferences(string $tailnet): Response
    {
        return $this->connector->send(
            request: new GetDnsPreferencesRequest(
                tailnet: $tailnet,
            ),
        );
    }

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
     * @param  string  $tailnet  The tailnet organization name.
     *
     * When specifying a tailnet in the API, you can:
     * - Provide a dash (-) to reference the default tailnet of the access token being used to make
     * the API call.
     * This is the best option for most users.
     * - Provide the organization name found on the General Settings page of the Tailscale admin console.
     *
     * @param  array{
     *     magicDNS: bool,
     * }  $data  Data for json body.
     *
     * Whether MagicDNS is active for this tailnet.
     *
     * @throws FatalRequestException|RequestException
     *
     * @see https://tailscale.com/api#tag/dns/POST/tailnet/%7Btailnet%7D/dns/preferences  Documentaion
     * @version Relevant for 2024-09-03, API v2, OAS 3.1.0
     */
    public function setDnsPreferences(string $tailnet, array $data): Response
    {
        return $this->connector->send(
            request: new SetDnsPreferencesRequest(
                tailnet: $tailnet,
                data: $data,
            ),
        );
    }

    /**
     * List DNS search paths.
     *
     * Retrieves the list of search paths, also referred to as search domains, that is currently set for the given
     * tailnet.
     *
     * @param  string  $tailnet  The tailnet organization name.
     *
     * When specifying a tailnet in the API, you can:
     * - Provide a dash (-) to reference the default tailnet of the access token being used to make
     * the API call.
     * This is the best option for most users.
     * - Provide the organization name found on the General Settings page of the Tailscale admin console.
     *
     * @throws FatalRequestException|RequestException
     *
     * @see https://tailscale.com/api#tag/dns/GET/tailnet/%7Btailnet%7D/dns/searchpaths  Documentaion
     * @version Relevant for 2024-09-03, API v2, OAS 3.1.0
     */
    public function listDnsSearchPaths(string $tailnet): Response
    {
        return $this->connector->send(
            request: new ListDnsSearchPathsRequest(
                tailnet: $tailnet,
            ),
        );
    }

    /**
     * Set DNS search paths
     *
     * Replaces the list of search paths for the given tailnet.
     *
     * @param  string  $tailnet  The tailnet organization name.
     *
     * When specifying a tailnet in the API, you can:
     * - Provide a dash (-) to reference the default tailnet of the access token being used to make
     * the API call. This is the best option for most users.
     * - Provide the organization name found on the General Settings page of the Tailscale admin console.
     *
     * @param  array{
     *     searchPaths: string[],
     * }  $data  Data for json body.
     *
     * The search domains for the given tailnet.
     *
     * @throws FatalRequestException|RequestException
     *
     * @see https://tailscale.com/api#tag/dns/POST/tailnet/%7Btailnet%7D/dns/searchpaths  Documentaion
     * @version Relevant for 2024-09-03, API v2, OAS 3.1.0
     */
    public function setDnsSearchPaths(string $tailnet, array $data): Response
    {
        return $this->connector->send(
            request: new SetDnsSearchPathsRequest(
                tailnet: $tailnet,
                data: $data,
            ),
        );
    }

    /**
     * Get split DNS.
     *
     * Retrieves the split DNS settings, which is a map from domains to lists of nameservers, that is currently set
     * for the given tailnet.
     *
     * @param  string  $tailnet  The tailnet organization name.
     *
     * When specifying a tailnet in the API, you can:
     * - Provide a dash (-) to reference the default tailnet of the access token being used to make the API call.
     * This is the best option for most users.
     * - Provide the organization name found on the General Settings page of the Tailscale admin console.
     *
     * @throws FatalRequestException|RequestException
     *
     * @see https://tailscale.com/api#tag/dns/GET/tailnet/%7Btailnet%7D/dns/split-dns  Documentaion
     * @version Relevant for 2024-09-03, API v2, OAS 3.1.0
     */
    public function getSplitDns(string $tailnet): Response
    {
        return $this->connector->send(
            request: new GetSplitDnsRequest(
                tailnet: $tailnet,
            ),
        );
    }

    /**
     * Update split DNS.
     *
     * Performs partial update of the split DNS settings for the given tailnet. Only domains specified in the
     * request map will be modified. Setting the value of a mapping to `null` clears the nameservers for that domain.
     *
     * @param  string  $tailnet  The tailnet organization name.
     *
     * When specifying a tailnet in the API, you can:
     * - Provide a dash (-) to reference the default tailnet of the access token being used to make the API call.
     * This is the best option for most users.
     * - Provide the organization name found on the General Settings page of the Tailscale admin console.
     *
     * @param  array<string, string[]|null>  $data  Data for json body.
     *
     * Map of domain names to lists of nameservers or to null.
     *
     * @throws FatalRequestException|RequestException
     *
     * @see https://tailscale.com/api#tag/dns/PATCH/tailnet/%7Btailnet%7D/dns/split-dns  Documentaion
     * @version Relevant for 2024-09-03, API v2, OAS 3.1.0
     */
    public function updateSplitDns(string $tailnet, array $data): Response
    {
        return $this->connector->send(
            request: new UpdateSplitDnsRequest(
                tailnet: $tailnet,
                data: $data,
            ),
        );
    }

    /**
     * Replace split DNS.
     *
     * Replaces the split DNS settings for a given tailnet. Setting the value of a mapping to null clears
     * the nameservers for that domain. Sending an empty object clears nameservers for all domains.
     *
     * @param  string  $tailnet  The tailnet organization name.
     *
     * When specifying a tailnet in the API, you can:
     * - Provide a dash (-) to reference the default tailnet of the access token being used to make the API call.
     * This is the best option for most users.
     * - Provide the organization name found on the General Settings page of the Tailscale admin console.
     *
     * @param  array<string, string[]|null>  $data  Data for json body.
     *
     * Map of domain names to lists of nameservers or to null.
     *
     * @throws FatalRequestException|RequestException
     *
     * @see https://tailscale.com/api#tag/dns/PUT/tailnet/%7Btailnet%7D/dns/split-dns  Documentaion
     * @version Relevant for 2024-09-03, API v2, OAS 3.1.0
     */
    public function setSplitDns(string $tailnet, array $data): Response
    {
        return $this->connector->send(
            request: new SetSplitDnsRequest(
                tailnet: $tailnet,
                data: $data,
            ),
        );
    }
}
