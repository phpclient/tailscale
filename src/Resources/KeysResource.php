<?php

declare(strict_types=1);

namespace PhpClient\Tailscale\Resources;

use PhpClient\Tailscale\Requests\Keys\CreateAuthKeyRequest;
use PhpClient\Tailscale\Requests\Keys\DeleteKeyRequest;
use PhpClient\Tailscale\Requests\Keys\GetKeyRequest;
use PhpClient\Tailscale\Requests\Keys\ListTailnetKeysRequest;
use Saloon\Exceptions\Request\FatalRequestException;
use Saloon\Exceptions\Request\RequestException;
use Saloon\Http\BaseResource;
use Saloon\Http\Response;

/**
 * @see https://tailscale.com/api#tag/keys  Documentation
 */
final class KeysResource extends BaseResource
{
    /**
     * List tailnet keys.
     *
     * Returns a list of active auth keys and API access tokens.
     * The set of keys returned depends on the access token used to make the request:
     * - If the API call is made with a user-owned API access token, this returns only the keys owned by that user.
     * - If the API call is made with an access token derived from an OAuth client, this returns all keys owned
     * directly by the tailnet.
     *
     * @param  string  $tailnet  The tailnet organization name.
     *
     * When specifying a tailnet in the API, you can:
     * - Provide a dash (-) to reference the default tailnet of the access token being used to make the API call.
     * This is the best option for most users.
     * - Provide the organization name found on the General Settings page of the Tailscale admin console.
     *
     * @throws FatalRequestException|RequestException
     *
     * @see https://tailscale.com/api#tag/keys/GET/tailnet/%7Btailnet%7D/keys  Documentation
     * @version Relevant for 2024-09-03, API v2, OAS 3.1.0
     */
    public function listTailnetKeys(string $tailnet): Response
    {
        return $this->connector->send(
            request: new ListTailnetKeysRequest(
                tailnet: $tailnet,
            ),
        );
    }

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
     *
     * @throws FatalRequestException|RequestException
     *
     * @see https://tailscale.com/api#tag/keys/POST/tailnet/%7Btailnet%7D/keys  Documentation
     * @version Relevant for 2024-09-03, API v2, OAS 3.1.0
     */
    public function createAuthKey(string $tailnet, array $data): Response
    {
        return $this->connector->send(
            request: new CreateAuthKeyRequest(
                tailnet: $tailnet,
                data: $data,
            ),
        );
    }

    /**
     * Get key.
     *
     * Returns a JSON object with information about a specific api access token or auth key, such as its creation and
     * expiration dates and its capabilities.
     *
     * @param  string  $tailnet  The tailnet organization name.
     *
     *  When specifying a tailnet in the API, you can:
     *  - Provide a dash (-) to reference the default tailnet of the access token being used to make the API call.
     *  This is the best option for most users.
     *  - Provide the organization name found on the General Settings page of the Tailscale admin console.
     *
     * @param  string  $keyId  The id of the key.
     * The key ID can be found in the admin console.
     *
     * @throws FatalRequestException|RequestException
     *
     * @see https://tailscale.com/api#tag/keys/GET/tailnet/%7Btailnet%7D/keys/%7BkeyId%7D  Documentation
     * @version Relevant for 2024-09-03, API v2, OAS 3.1.0
     */
    public function getKey(string $tailnet, string $keyId): Response
    {
        return $this->connector->send(
            request: new GetKeyRequest(
                tailnet: $tailnet,
                keyId: $keyId,
            ),
        );
    }

    /**
     * Delete key.
     *
     * Deletes a specific api access token or auth key.
     *
     * @param  string  $tailnet  The tailnet organization name.
     *
     * When specifying a tailnet in the API, you can:
     * - Provide a dash (-) to reference the default tailnet of the access token being used to make the API call.
     * This is the best option for most users.
     * - Provide the organization name found on the General Settings page of the Tailscale admin console.
     *
     * @param  string  $keyId  The id of the key.
     * The key ID can be found in the admin console.
     *
     * @throws FatalRequestException|RequestException
     *
     * @see https://tailscale.com/api#tag/keys/DELETE/tailnet/%7Btailnet%7D/keys/%7BkeyId%7D  Documentation
     * @version Relevant for 2024-09-03, API v2, OAS 3.1.0
     */
    public function deleteKey(string $tailnet, string $keyId): Response
    {
        return $this->connector->send(
            request: new DeleteKeyRequest(
                tailnet: $tailnet,
                keyId: $keyId,
            ),
        );
    }
}
