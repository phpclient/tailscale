<?php

declare(strict_types=1);

namespace PhpClient\Tailscale\Requests\Users;

use Saloon\Enums\Method;
use Saloon\Http\Request;

use function array_filter;

/**
 * List users.
 *
 * List all users of a tailnet.
 *
 * @see  https://tailscale.com/api#tag/users/GET/tailnet/%7Btailnet%7D/users  Documentaion
 * @version Relevant for 2024-09-03, API v2, OAS 3.1.0
 */
final class ListUsersRequest extends Request
{
    protected Method $method = Method::GET;

    /**
     * @param  string  $tailnet  The tailnet organization name.
     *
     *   When specifying a tailnet in the API, you can:
     *   - Provide a dash (-) to reference the default tailnet of the access token being used to make the API call.
     *   This is the best option for most users.
     *   - Provide the organization name found on the General Settings page of the Tailscale admin console.
     *
     * @param  string|null  $type  Allow for filtering the output by user type.
     *
     * @param  string|null  $role  Allow for filtering the output by user role.
     */
    public function __construct(
        private readonly string $tailnet,
        private readonly ?string $type = null,
        private readonly ?string $role = null,
    ) {}

    public function resolveEndpoint(): string
    {
        return "/tailnet/{$this->tailnet}/users";
    }

    public function defaultQuery(): array
    {
        return array_filter(array: [
            'type' => $this->type,
            'role' => $this->role,
        ]);
    }
}
