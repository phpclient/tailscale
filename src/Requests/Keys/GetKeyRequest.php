<?php

declare(strict_types=1);

namespace PhpClient\Tailscale\Requests\Keys;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Get key.
 *
 * Returns a JSON object with information about a specific api access token or auth key, such as its creation and
 * expiration dates and its capabilities.
 *
 * @see https://tailscale.com/api#tag/keys/GET/tailnet/%7Btailnet%7D/keys/%7BkeyId%7D  Documentation
 * @version Relevant for 2024-09-03, API v2, OAS 3.1.0
 */
final class GetKeyRequest extends Request
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
     * @param  string  $keyId  The id of the key.
     * The key ID can be found in the admin console.
     */
    public function __construct(
        private readonly string $tailnet,
        private readonly string $keyId,
    ) {}


    public function resolveEndpoint(): string
    {
        return "/tailnet/$this->tailnet/keys/$this->keyId";
    }
}
