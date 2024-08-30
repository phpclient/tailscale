<?php

declare(strict_types=1);

namespace PhpClient\Tailscale\Resources;

use PhpClient\Tailscale\Enums\ContactType;
use PhpClient\Tailscale\Requests\Contacts\TailnetContactsGet;
use PhpClient\Tailscale\Requests\Contacts\TailnetContactsPatch;
use PhpClient\Tailscale\Requests\Contacts\TailnetContactsPost;
use Saloon\Exceptions\Request\FatalRequestException;
use Saloon\Exceptions\Request\RequestException;
use Saloon\Http\BaseResource;
use Saloon\Http\Response;

/**
 * @see https://tailscale.com/api#tag/contacts  Documentation
 */
final class ContactsResource extends BaseResource
{
    /**
     * Retrieve the tailnet's current contacts.
     *
     * @throws FatalRequestException|RequestException
     *
     * @see https://tailscale.com/api#tag/policyfile/GET/tailnet/%7Btailnet%7D/contacts  Documentation
     * @version Relevant for 2024-08-30, API v2, OAS 3.1.0
     */
    public function get(string $tailnet): Response
    {
        return $this->connector->send(
            request: new TailnetContactsGet(
                tailnet: $tailnet,
            ),
        );
    }

    /**
     * Retrieve the tailnet's current contacts.
     *
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
     *
     * @throws FatalRequestException|RequestException
     *
     * @see https://tailscale.com/api#tag/contacts/PATCH/tailnet/%7Btailnet%7D/contacts/%7BcontactType%7D  Documentation
     * @version Relevant for 2024-08-30, API v2, OAS 3.1.0
     */
    public function patch(string $tailnet, ContactType $contactType, array $data): Response
    {
        return $this->connector->send(
            request: new TailnetContactsPatch(
                tailnet: $tailnet,
                contactType: $contactType,
                data: $data,
            ),
        );
    }

    /**
     * Resends the verification email for this contact, if and only if verification is still pending.
     *
     * @param string $tailnet The tailnet organization name.
     *
     * When specifying a tailnet in the API, you can:
     * - Provide a dash (-) to reference the default tailnet of the access token being used to make the API call.
     * This is the best option for most users.
     * - Provide the organization name found on the General Settings page of the Tailscale admin console.
     *
     * @param ContactType $contactType Type of contact.
     *
     * @throws FatalRequestException|RequestException
     *
     * @see https://tailscale.com/api#tag/contacts/POST/tailnet/%7Btailnet%7D/contacts/%7BcontactType%7D/resend-verification-email  Documentation
     * @version Relevant for 2024-08-30, API v2, OAS 3.1.0
     */
    public function post(string $tailnet, ContactType $contactType): Response
    {
        return $this->connector->send(
            request: new TailnetContactsPost(
                tailnet: $tailnet,
                contactType: $contactType,
            ),
        );
    }
}
