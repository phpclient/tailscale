<?php

declare(strict_types=1);

namespace PhpClient\Tailscale\Requests\Contacts;

use PhpClient\Tailscale\Enums\ContactType;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * Retrieve the tailnet's current contacts.
 *
 * @see https://tailscale.com/api#tag/contacts/PATCH/tailnet/%7Btailnet%7D/contacts/%7BcontactType%7D  Documentation
 * @version Relevant for 2024-08-30, API v2, OAS 3.1.0
 */
final class TailnetContactsPatch extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::PATCH;

    /**
     * @param string $tailnet The tailnet organization name.
     *
     * When specifying a tailnet in the API, you can:
     * - Provide a dash (-) to reference the default tailnet of the access token being used to make the API call.
     * This is the best option for most users.
     * - Provide the organization name found on the General Settings page of the Tailscale admin console.
     *
     * @param ContactType $contactType Type of contact.
     *
     * @param array{email: string} $data Data for json body.
     *
     * Required body fields:
     * - email: string - The contact's email address.
     */
    public function __construct(
        private readonly string $tailnet,
        private readonly ContactType $contactType,
        private readonly array $data,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return "/tailnet/$this->tailnet/contacts/{$this->contactType->value}";
    }

    protected function defaultBody(): array
    {
        return $this->data;
    }
}
