<?php

declare(strict_types=1);

namespace PhpClient\Tailscale\Requests\Acl;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * This endpoint works in one of two modes, neither of which modifies your current tailnet policy file:
 *
 * Run ACL tests:
 * - When the request body contains ACL tests as a JSON array, Tailscale runs ACL tests against the tailnet's
 * current policy file. Learn more about ACL tests.
 *
 * Validate a new policy file:
 * - When the request body is a JSON object, Tailscale interprets the body as a hypothetical new tailnet policy file
 * with new ACLs, including any new rules and tests. It validates that the policy file is parsable and runs tests
 * to validate the existing rules.
 *
 * In either case, this method does not modify the tailnet policy file in any way.
 *
 * @see https://tailscale.com/api#tag/policyfile/POST/tailnet/%7Btailnet%7D/acl/validate  Documentation
 * @version Relevant for 2024-08-30, API v2, OAS 3.1.0
 */
final class TailnetAclValidatePostRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    /**
     * @param string $tailnet The tailnet organization name.
     *
     * When specifying a tailnet in the API, you can:
     * - Provide a dash (-) to reference the default tailnet of the access token being used to make the API call.
     * This is the best option for most users.
     * - Provide the organization name found on the General Settings page of the Tailscale admin console.
     *
     * @param array $data Data for json body: "Array of ACL tests" or "Representation of the policy file"
     */
    public function __construct(
        private readonly string $tailnet,
        private readonly array $data,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return "/tailnet/$this->tailnet/acl/validate";
    }

    protected function defaultBody(): array
    {
        return $this->data;
    }
}
