<?php

declare(strict_types=1);

namespace PhpClient\Tailscale\Requests\Dns;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * List DNS search paths.
 *
 * Retrieves the list of search paths, also referred to as search domains, that is currently set for the given tailnet.
 *
 * @see https://tailscale.com/api#tag/dns/GET/tailnet/%7Btailnet%7D/dns/searchpaths  Documentation
 * @version Relevant for 2024-09-03, API v2
 */
final class ListDnsSearchPathsRequest extends Request
{
    protected Method $method = Method::GET;

    /**
     * @param string $tailnet The tailnet organization name.
     *
     * When specifying a tailnet in the API, you can:
     * - Provide a dash (-) to reference the default tailnet of the access token being used to make the API call.
     * This is the best option for most users.
     * - Provide the organization name found on the General Settings page of the Tailscale admin console.
     */
    public function __construct(
        private readonly string $tailnet,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return "/tailnet/$this->tailnet/dns/searchpaths";
    }
}
