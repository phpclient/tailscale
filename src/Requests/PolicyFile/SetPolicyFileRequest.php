<?php

declare(strict_types=1);

namespace PhpClient\Tailscale\Requests\PolicyFile;

use PhpClient\Tailscale\Enums\AcceptHeader;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

use function array_filter;
use function array_merge;

/**
 * Sets the ACL for the given tailnet. HuJSON and JSON are both accepted inputs.
 *
 * @see https://tailscale.com/api#tag/policyfile/POST/tailnet/%7Btailnet%7D/acl  Documentation
 * @version Relevant for 2024-08-30, API v2, OAS 3.1.0
 */
final class SetPolicyFileRequest extends Request implements HasBody
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
     * @param array $data Data for json body
     *
     * @param string|null $ifMatchEtag This is a safety mechanism to avoid overwriting other users' updates to
     * the tailnet policy file.
     *
     * Set the If-Match value to that of the ETag header returned in a GET request to /api/v2/tailnet/{tailnet}/acl.
     * Tailscale compares the ETag value in your request to that of the current tailnet file and only replaces the file
     * if there's a match. (A mismatch indicates that another update has been made to the file.)
     *
     * Alternately, set the If-Match value to "ts-default" to ensure that the policy file is replaced only if
     * the current policy file is still the untouched default created automatically for each tailnet.
     *
     * @param AcceptHeader $acceptHeader Response is encoded as JSON or as HuJSON.
     */
    public function __construct(
        private readonly string $tailnet,
        private readonly array $data,
        private readonly ?string $ifMatchEtag = null,
        private readonly AcceptHeader $acceptHeader = AcceptHeader::JSON,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return "/tailnet/$this->tailnet/acl";
    }

    protected function defaultHeaders(): array
    {
        return array_merge(
            array_filter(array: [
                'If-Match' => $this->ifMatchEtag,
            ]),
            $this->acceptHeader === AcceptHeader::HUJSON ? [
                // SaloonPHP do not provide ability to completely remove header from request,
                // if it already specified in connector default headers.
                // todo: Check if tailscale can process header with null value.
                'Accept' => null,
            ] : [
                // Header "Accept: application/json" will be sent according to default headers in tailscale connector,
            ],
        );
    }

    protected function defaultBody(): array
    {
        return $this->data;
    }
}
