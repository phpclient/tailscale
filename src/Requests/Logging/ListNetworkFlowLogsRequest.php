<?php

declare(strict_types=1);

namespace PhpClient\Tailscale\Requests\Logging;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * List network flow logs.
 *
 * List all network flow logs for a tailnet.
 *
 * @see https://tailscale.com/api#tag/logging/GET/tailnet/%7Btailnet%7D/logging/network  Documentation
 * @version Relevant for 2024-09-03, API v2, OAS 3.1.0
 */
class ListNetworkFlowLogsRequest extends Request
{
    protected Method $method = Method::GET;

    /**
     * @param  string  $tailnet  The tailnet organization name.
     *
     *  When specifying a tailnet in the API, you can:
     *  - Provide a dash (-) to reference the default tailnet of the access token being used to make the API call.
     *  This is the best option for most users.
     *  - Provide the organization name found on the General Settings page of the Tailscale admin console.
     *
     * @param  string  $start  The  start of the time window for which to retrieve logs, in RFC 3339 format.
     *
     * @param  string  $end  The end of the time window for which to retrieve logs, in RFC 3339 format.
     */
    public function __construct(
        private readonly string $tailnet,
        private readonly string $start,
        private readonly string $end,
    ) {}

    public function resolveEndpoint(): string
    {
        return "/tailnet/$this->tailnet/logging/network";
    }

    protected function defaultQuery(): array
    {
        return [
            'start' => $this->start,
            'end' => $this->end,
        ];
    }
}