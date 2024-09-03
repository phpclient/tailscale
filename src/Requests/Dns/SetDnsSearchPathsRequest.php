<?php

declare(strict_types=1);

namespace PhpClient\Tailscale\Requests\Dns;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * Set DNS search paths.
 *
 * Replaces the list of search paths for the given tailnet.
 *
 * @see https://tailscale.com/api#tag/dns/POST/tailnet/%7Btailnet%7D/dns/searchpaths  Documentation
 * @version Relevant for 2024-09-03, API v2
 */
final class SetDnsSearchPathsRequest extends Request implements HasBody
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
     *     searchPaths: array<string>,
     * }  $data  Data for json body.
     *
     *  The search domains for the given tailnet.
     */
    public function __construct(
        private readonly string $tailnet,
        private readonly array $data,
    ) {}

    public function resolveEndpoint(): string
    {
        return "/tailnet/$this->tailnet/dns/searchpaths";
    }

    protected function defaultBody(): array
    {
        return $this->data;
    }
}
