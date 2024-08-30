<?php

declare(strict_types=1);

namespace PhpClient\Tailscale\Requests\Contacts;

use PhpClient\Tailscale\Enums\ContactType;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Resends the verification email for this contact, if and only if verification is still pending.
 *
 * @see https://tailscale.com/api#tag/contacts/POST/tailnet/%7Btailnet%7D/contacts/%7BcontactType%7D/resend-verification-email  Documentation
 * @version Relevant for 2024-08-30, API v2, OAS 3.1.0
 */
final class TailnetContactsPost extends Request
{
    protected Method $method = Method::POST;

    /**
     * @param string $tailnet The tailnet organization name.
     *
     * When specifying a tailnet in the API, you can:
     * - Provide a dash (-) to reference the default tailnet of the access token being used to make the API call.
     * This is the best option for most users.
     * - Provide the organization name found on the General Settings page of the Tailscale admin console.
     *
     * @param ContactType $contactType Type of contact.
     */
    public function __construct(
        private readonly string $tailnet,
        private readonly ContactType $contactType,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return "/tailnet/$this->tailnet/contacts/{$this->contactType->value}/resend-verification-email";
    }
}
