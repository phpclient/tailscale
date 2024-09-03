<?php

declare(strict_types=1);

namespace PhpClient\Tailscale\Requests\Dns;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * Set DNS nameservers
 *
 * Replaces the list of global DNS nameservers for the given tailnet with the list supplied in the request.
 *
 * Note that changing the list of DNS nameservers may also affect the status of MagicDNS .
 * If all nameservers have been removed, MagicDNS will be automatically disabled (until explicitly turned back
 * on by the user).
 *
 * @see https://tailscale.com/api#tag/dns/POST/tailnet/%7Btailnet%7D/dns/nameservers  Documentaion
 * @version Relevant for 2024-09-03, API v2, OAS 3.1.0
 */
final class SetDnsNameserversRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    /**
     * @param  string  $tailnet  The tailnet organization name.
     *
     * When specifying a tailnet in the API, you can:
     * - Provide a dash (-) to reference the default tailnet of the access token being used to make the API call.
     * This is the best option for most users.
     * - Provide the organization name found on the General Settings page of the Tailscale admin console.
     *
     * @param  array{
     *     dns: array<string>,
     * }  $data  Data for json body.
     *
     * DNS nameservers.
     */
    public function __construct(
        private readonly string $tailnet,
        private readonly array $data,
    ) {}

    public function resolveEndpoint(): string
    {
        return "/tailnet/$this->tailnet/dns/nameservers";
    }

    protected function defaultBody(): array
    {
        return $this->data;
    }
}
