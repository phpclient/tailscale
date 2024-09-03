<?php

declare(strict_types=1);

namespace PhpClient\Tailscale\Requests\Logging;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Get log streaming status.
 *
 * Retrieve the log streaming status for the provided log type.
 *
 * @see https://tailscale.com/api#tag/logging/GET/tailnet/%7Btailnet%7D/logging/%7BlogType%7D/stream/status  Documentation
 * @version Relevant for 2024-09-03, API v2, OAS 3.1.0
 */
final class GetLogStreamingStatusRequest extends Request
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
     * @param  string  $logType  The type of log.
     * - configuration
     * - network
     */
    public function __construct(
        public readonly string $tailnet,
        public readonly string $logType,
    ) {}

    public function resolveEndpoint(): string
    {
        return "/tailnet/$this->tailnet/logging/$this->logType/stream/status";
    }
}
