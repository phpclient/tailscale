<?php

declare(strict_types=1);

namespace PhpClient\Tailscale\Enums;

enum AcceptHeader
{
    case JSON;

    case HUJSON;
}
