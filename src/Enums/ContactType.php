<?php

declare(strict_types=1);

namespace PhpClient\Tailscale\Enums;

enum ContactType: string
{
    case ACCOUNT = 'account';

    case SUPPORT = 'support';

    case SECURITY = 'security';
}
