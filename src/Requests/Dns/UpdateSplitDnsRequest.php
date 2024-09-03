<?php

declare(strict_types=1);

namespace PhpClient\Tailscale\Requests\Dns;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * Update split DNS.
 *
 * Performs partial updates of the split DNS settings for a given tailnet.
 * Only domains specified in the request map will be modified.
 * Setting the value of a mapping to `null` clears the nameservers for that domain.
 *
 * @see https://tailscale.com/api#tag/dns/PATCH/tailnet/%7Btailnet%7D/dns/split-dns  Documentation
 * @version Relevant for 2024-09-03, API v2, OAS 3.1.0
 */
final class UpdateSplitDnsRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::PATCH;

    /**
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
     */
    public function __construct(
        private readonly string $tailnet,
        private readonly array $data,
    ) {}

    public function resolveEndpoint(): string
    {
        return "/tailnet/$this->tailnet/dns/split-dns";
    }

    protected function defaultBody(): array
    {
        return $this->data;
    }
}
