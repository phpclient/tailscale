<?php

declare(strict_types=1);

namespace PhpClient\Tailscale;

use PhpClient\Tailscale\Resources\AclResource;
use Saloon\Contracts\Authenticator;
use Saloon\Http\Auth\TokenAuthenticator;
use Saloon\Http\Connector;

/**
 * @see https://tailscale.com/api
 */
final class TailscaleClient extends Connector
{
    /**
     * @param string $token API access token
     */
    public function __construct(
        private readonly string $token,
    )
    {
    }

    /**
     * @see https://tailscale.com/api#description/base-url  Documentation
     */
    public function resolveBaseUrl(): string
    {
        return 'https://api.tailscale.com/api/v2';
    }

    /**
     * @see https://tailscale.com/api#description/authentication  Documetnation
     */
    protected function defaultAuth(): ?Authenticator
    {
        return new TokenAuthenticator(token: $this->token);
    }

    protected function defaultHeaders(): array
    {
        return [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ];
    }

    public function aclResource(): AclResource
    {
        return new AclResource(
            connector: $this,
        );
    }
}
