<?php

declare(strict_types=1);

namespace PhpClient\Tailscale\Requests\Devices;

use Saloon\Enums\Method;
use Saloon\Http\Request;

use function array_filter;

/**
 * Lists the devices in a tailnet.
 *
 * @see https://tailscale.com/api#tag/devices/GET/tailnet/%7Btailnet%7D/devices  Documentation
 */
final class ListTailnetDevicesRequest extends Request
{
    protected Method $method = Method::GET;

    /**
     * @param  string  $tailnet  The tailnet organization name.
     *
     * When specifying a tailnet in the API, you can:
     * - Provide a dash (-) to reference the default tailnet of the access token being used to make the API call.
     * This is the best option for most users.
     * - Provide the organization name found on the General Settings page of the Tailscale admin console.
     *
     * @param  string|null  $fields  Optionally controls whether the response returns all fields or only a predefined
     * subset of fields.
     *
     * Currently, there are two supported options:
     * - all: return all fields in the response
     * - default: return all fields except:
     *      - enabledRoutes
     *      - advertisedRoutes
     *      - clientConnectivity
     *
     * If the fields parameter is not supplied, then the default (limited fields) option is used.
     */
    public function __construct(
        private readonly string $tailnet,
        private readonly ?string $fields = null,
    ) {}

    public function resolveEndpoint(): string
    {
        return "/tailnet/$this->tailnet/devices";
    }

    protected function defaultQuery(): array
    {
        return array_filter(array: [
            'fields' => $this->fields,
        ]);
    }
}
