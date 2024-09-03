<?php

declare(strict_types=1);

namespace PhpClient\Tailscale\Resources;

use PhpClient\Tailscale\Requests\Logging\DisableLogStreamingRequest;
use PhpClient\Tailscale\Requests\Logging\GetLogStreamingConfigurationRequest;
use PhpClient\Tailscale\Requests\Logging\GetLogStreamingStatusRequest;
use PhpClient\Tailscale\Requests\Logging\ListConfigurationAuditLogsRequest;
use PhpClient\Tailscale\Requests\Logging\ListNetworkFlowLogsRequest;
use PhpClient\Tailscale\Requests\Logging\SetLogStreamingConfigurationRequest;
use Saloon\Exceptions\Request\FatalRequestException;
use Saloon\Exceptions\Request\RequestException;
use Saloon\Http\BaseResource;
use Saloon\Http\Response;

/**
 *
 * @see https://tailscale.com/api#tag/logging  Documentation
 */
final class LoggingResource extends BaseResource
{
    /**
     * List configuration audit logs.
     *
     * List all configuration audit logs for a tailnet.
     *
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
     *
     * @throws FatalRequestException|RequestException
     *
     * @see https://tailscale.com/api#tag/logging/GET/tailnet/%7Btailnet%7D/logging/configuration  Documentation
     * @version Relevant for 2024-09-03, API v2, OAS 3.1.0
     */

    public function listConfigurationAuditLogs(
        string $tailnet,
        string $start,
        string $end,
        array $actor,
        array $target,
        array $event,
    ): Response {
        return $this->connector->send(
            request: new ListConfigurationAuditLogsRequest(
                tailnet: $tailnet,
                start: $start,
                end: $end,
                actor: $actor,
                target: $target,
                event: $event,
            ),
        );
    }

    /**
     * List network flow logs.
     *
     * List all network flow logs for a tailnet.
     *
     * @param  string  $tailnet  The tailnet organization name.
     *
     * When specifying a tailnet in the API, you can:
     * - Provide a dash (-) to reference the default tailnet of the access token being used to make the API call.
     * This is the best option for most users.
     * - Provide the organization name found on the General Settings page of the Tailscale admin console.
     *
     * @param  string  $start  The  start of the time window for which to retrieve logs, in RFC 3339 format.
     *
     * @param  string  $end  The end of the time window for which to retrieve logs, in RFC 3339 format.
     *
     * @throws FatalRequestException|RequestException
     *
     * @see https://tailscale.com/api#tag/logging/GET/tailnet/%7Btailnet%7D/logging/network  Documentation
     * @version Relevant for 2024-09-03, API v2, OAS 3.1.0
     * */
    public function listNetworkFlowLogs(string $tailnet, string $start, string $end): Response
    {
        return $this->connector->send(
            request: new ListNetworkFlowLogsRequest(
                tailnet: $tailnet,
                start: $start,
                end: $end,
            ),
        );
    }

    /**
     * Get log streaming status.
     *
     * Retrieve the log streaming status for the provided log type.
     *
     * @param  string  $tailnet  The tailnet organization name.
     *
     * When specifying a tailnet in the API, you can:
     * - Provide a dash (-) to reference the default tailnet of the access token being used to make the API call.
     * This is the best option for most users.
     * - Provide the organization name found on the General Settings page of the Tailscale admin console.
     *
     * @param  string  $logType  The type of log.
     * - configuration
     * - network
     *
     * @throws FatalRequestException|RequestException
     *
     * @see https://tailscale.com/api#tag/logging/GET/tailnet/%7Btailnet%7D/logging/%7BlogType%7D/stream/status  Documentation
     * @version Relevant for 2024-09-03, API v2, OAS 3.1.0
     */
    public function getLogStreamingStatus(string $tailnet, string $logType): Response
    {
        return $this->connector->send(
            request: new GetLogStreamingStatusRequest(
                tailnet: $tailnet,
                logType: $logType,
            ),
        );
    }

    /**
     * Get log streaming configuration.
     *
     * Retrieve the log streaming configuration for the provided log type.
     *
     * @param  string  $tailnet  The tailnet organization name.
     *
     * When specifying a tailnet in the API, you can:
     * - Provide a dash (-) to reference the default tailnet of the access token being used to make the API call.
     * This is the best option for most users.
     * - Provide the organization name found on the General Settings page of the Tailscale admin console.
     *
     * @param  string  $logType  The type of log.
     *  - configuration
     *  - network
     *
     * @throws FatalRequestException|RequestException
     *
     * @see https://tailscale.com/api#tag/logging/GET/tailnet/%7Btailnet%7D/logging/%7BlogType%7D/stream  Documentation
     * @version Relevant for 2024-09-03, API v2, OAS 3.1.0
     */
    public function getLogStreamingConfiguration(string $tailnet, string $logType): Response
    {
        return $this->connector->send(
            request: new GetLogStreamingConfigurationRequest(
                tailnet: $tailnet,
                logType: $logType,
            ),
        );
    }

    /**
     * Set log streaming configuration
     *
     * Set the log streaming configuration for the provided log type.
     *
     * @param  string  $tailnet  The tailnet organization name.
     *
     * When specifying a tailnet in the API, you can:
     * - Provide a dash (-) to reference the default tailnet of the access token being used to make the API call.
     * This is the best option for most users.
     * - Provide the organization name found on the General Settings page of the Tailscale admin console.
     *
     * @param  string  $logType  The type of log.
     *  - configuration
     *  - network
     *
     * @param  array{
     *     destinationType: string,
     *     url: string,
     *     user: string,
     *     token: string,
     * }  $data  Data for json body.
     *
     * @throws FatalRequestException|RequestException
     *
     * @see https://tailscale.com/api#tag/logging/PUT/tailnet/%7Btailnet%7D/logging/%7BlogType%7D/stream  Documentation
     * @version Relevant for 2024-09-03, API v2, OAS 3.1.0
     */
    public function setLogStreamingConfiguration(string $tailnet, string $logType, array $data): Response
    {
        return $this->connector->send(
            request: new SetLogStreamingConfigurationRequest(
                tailnet: $tailnet,
                logType: $logType,
                data: $data,
            ),
        );
    }

    /**
     * Disable log streaming
     *
     * Delete the log streaming configuration for the provided log type.
     *
     * @param  string  $tailnet  The tailnet organization name.
     *
     * When specifying a tailnet in the API, you can:
     * - Provide a dash (-) to reference the default tailnet of the access token being used to make the API call.
     * This is the best option for most users.
     * - Provide the organization name found on the General Settings page of the Tailscale admin console.
     *
     * @param  string  $logType  The type of log.
     *   - configuration
     *   - network
     *
     * @throws FatalRequestException|RequestException
     *
     * @see https://tailscale.com/api#tag/logging/DELETE/tailnet/%7Btailnet%7D/logging/%7BlogType%7D/stream  Documentation
     * @version Relevant for 2024-09-03, API v2, OAS 3.1.0
     */

    public function disableLogStreaming(string $tailnet, string $logType): Response
    {
        return $this->connector->send(
            request: new DisableLogStreamingRequest(
                tailnet: $tailnet,
                logType: $logType,
            ),
        );
    }
}
