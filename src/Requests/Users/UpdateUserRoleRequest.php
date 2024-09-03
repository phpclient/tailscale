<?php

declare(strict_types=1);

namespace PhpClient\Tailscale\Requests\Users;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * Update user role.
 *
 * Update the role for the specified user.
 *
 * @see  https://tailscale.com/api#tag/users/POST/users/%7BuserId%7D/role  Documentaion
 * @version Relevant for 2024-09-03, API v2, OAS 3.1.0
 */
final class UpdateUserRoleRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    /**
     * @param  string  $userId  ID of the user.
     *
     * @param  array{
     *     role: string,
     * }  $data  Data for json body.
     */
    public function __construct(
        private readonly string $userId,
        private readonly array $data,
    ) {}

    public function resolveEndpoint(): string
    {
        return "/users/$this->userId/role";
    }

    public function defaultBody(): array
    {
        return $this->data;
    }
}
