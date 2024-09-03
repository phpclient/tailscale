<?php

declare(strict_types=1);

namespace PhpClient\Tailscale\Requests\UserInvites;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * Create user invites.
 *
 * Create, and optionally email out, new user invites to join the tailnet.
 *
 * @see  https://tailscale.com/api#tag/userinvites/POST/tailnet/%7Btailnet%7D/user-invites  Documentation
 * @version Relevant for 2024-09-03, API v2, OAS 3.1.0
 */
final class CreateUserInvitesRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    /**
     * @param  string  $tailnet  The tailnet organization name.
     *
     *  When specifying a tailnet in the API, you can:
     *  - Provide a dash (-) to reference the default tailnet of the access token being used to make the API call.
     *  This is the best option for most users.
     *  - Provide the organization name found on the General Settings page of the Tailscale admin console.
     *
     * @param  array{
     *     role: string,
     *     email: string,
     * }[]  $data  Data for json body.
     *
     * @see  https://tailscale.com/api#tag/userinvites/POST/tailnet/%7Btailnet%7D/user-invites  Documentation
     * @version Relevant for 2024-09-03, API v2, OAS 3.1.0
     */

    public function __construct(
        public string $tailnet,
        public array $data,
    ) {}

    public function resolveEndpoint(): string
    {
        return "/tailnet/$this->tailnet/user-invites";
    }

    public function defaultBody(): array
    {
        return $this->data;
    }
}
