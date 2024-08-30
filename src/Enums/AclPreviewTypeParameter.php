<?php

declare(strict_types=1);

namespace PhpClient\Tailscale\Enums;

enum AclPreviewTypeParameter: string
{
    case USER = 'user';
    case IPPORT = 'ipport';
}
