<?php

declare(strict_types=1);

namespace PhpClient\Tailscale\Requests\Keys;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * List tailnet keys.
 *
 * Returns a list of active auth keys and API access tokens.
 * The set of keys returned depends on the access token used to make the request:
 * - If the API call is made with a user-owned API access token, this returns only the keys owned by that user.
 * - If the API call is made with an access token derived from an OAuth client, this returns all keys owned
 * directly by the tailnet.
 *
 * @see https://tailscale.com/api#tag/keys/GET/tailnet/%7Btailnet%7D/keys  Documentation
 * @version Relevant for 2024-09-03, API v2, OAS 3.1.0
 */
final class ListTailnetKeysRequest extends Request
{
    protected Method $method = Method::GET;

    /**
     * @param  string  $tailnet  The tailnet organization name.
     *
     * When specifying a tailnet in the API, you can:
     * - Provide a dash (-) to reference the default tailnet of the access token being used to make the API call.
     * This is the best option for most users.
     * - Provide the organization name found on the General Settings page of the Tailscale admin console.
     */
    public function __construct(
        private readonly string $tailnet,
    ) {}


    public function resolveEndpoint(): string
    {
        return "/tailnet/{$this->tailnet}/keys";
    }
}
