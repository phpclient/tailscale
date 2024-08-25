<?php

declare(strict_types=1);

namespace PhpClient\Tailscale;

use Saloon\Http\Connector;

final class TailscaleClient extends Connector
{
    public readonly CommonActions $actions;

    public function __construct(
        private readonly string $token,
        private readonly string $baseUrl = 'https://api.tailscale.com/api/v2',
    )  {
        $this->actions = new CommonActions(client: $this);
    }

    public function resolveBaseUrl(): string
    {
        return $this->baseUrl;
    }

    protected function defaultHeaders(): array
    {
        return [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => "Bearer $this->token",
        ];
    }
}
