<?php

declare(strict_types=1);

namespace PhpClient\Tailscale\Requests\Logging;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * List configuration audit logs.
 *
 * List all configuration audit logs for a tailnet.
 *
 * @see https://tailscale.com/api#tag/logging/GET/tailnet/%7Btailnet%7D/logging/configuration  Documentation
 * @version Relevant for 2024-09-03, API v2, OAS 3.1.0
 */
final class ListConfigurationAuditLogsRequest extends Request
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
     *
     * @param  string[]  $actor  List of filters on actors, either exact actor IDs or a wildcard search on login
     * name or display name indicated as ~search.
     *
     * @param  string[]  $target  List of target elements for which to filter, attempts to match any part of any of
     * the targets to any of the given strings.
     *
     * @param  string[]  $event  List of events for which to filter.
     */
    public function __construct(
        public readonly string $tailnet,
        public readonly string $start,
        public readonly string $end,
        public readonly array $actor,
        public readonly array $target,
        public readonly array $event,
    ) {}

    public function resolveEndpoint(): string
    {
        return "/tailnet/$this->tailnet/logging/configuration";
    }

    public function defaultQuery(): array
    {
        return [
            'start' => $this->start,
            'end' => $this->end,
            'actor' => $this->actor,
            'target' => $this->target,
            'event' => $this->event,
        ];
    }
}
