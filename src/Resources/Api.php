<?php

declare(strict_types=1);

namespace PhpClient\Tailscale\Resources;

use Saloon\Http\BaseResource;

final class Api extends BaseResource
{
    public function policyFile(): PolicyFileResource
    {
        return new PolicyFileResource(
            connector: $this->connector,
        );
    }
}
