<?php

declare(strict_types=1);

namespace PhpClient\Tailscale;

use PhpClient\Tailscale\Resources\AclResource;
use Saloon\Http\BaseResource;

final class Api extends BaseResource
{
    public function acl(): AclResource
    {
        return new AclResource(
            connector: $this->connector,
        );
    }
}
