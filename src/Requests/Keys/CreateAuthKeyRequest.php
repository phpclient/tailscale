<?php

declare(strict_types=1);

namespace PhpClient\Tailscale\Requests\Keys;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * Create auth key.
 *
 * Creates a new auth key in the specified tailnet. The key will be associated with the user who owns the API access
 * token used to make this call, or, if the call is made with an access token derived from an OAuth client, the key
 * will be owned by the tailnet.
 *
 * Returns a JSON object with the supplied capabilities in addition to the generated key. The key should be recorded
 * and kept safe and secure because it wields the capabilities specified in the request. The identity of the key
 * is embedded in the key itself and can be used to perform operations on the key (e.g., revoking it or retrieving
 * information about it). The full key can no longer be retrieved after the initial response.
 *
 * @see https://tailscale.com/api#tag/keys/POST/tailnet/%7Btailnet%7D/keys  Documentation
 * @version Relevant for 2024-09-03, API v2, OAS 3.1.0
 */
final class CreateAuthKeyRequest extends Request implements HasBody
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
     *     capabilities: array{
     *         devices: array{
     *             create: array{
     *                 reusable: bool,
     *                 ephemeral: bool,
     *                 preauthorized: bool,
     *                 tags: string[],
     *             },
     *         },
     *     },
     *     expirySeconds?: int,
     *     description?: string,
     * }  $data  The request data.
     *
     * At a minimum, the request POST body must have a capabilities object with a devices object, though it can be an
     * empty JSON object. With nothing else supplied, such a request generates a single-use key with no tags.
     *
     * - capabilities
     * Is a mapping of resources to permissible actions.
     *
     * - expirySeconds
     * Specifies the duration in seconds until the key should expire. Defaults to 90 days if not supplied.
     *
     * - description
     * A short string specifying the purpose of the key. Can be a maximum of 50 alphanumeric characters.
     * Hyphens and spaces are also allowed.
     */
    public function __construct(
        private readonly string $tailnet,
        private readonly array $data,
    ) {}


    public function resolveEndpoint(): string
    {
        return "/tailnet/{$this->tailnet}/keys";
    }

    public function defaultBody(): array
    {
        return $this->data;
    }
}
