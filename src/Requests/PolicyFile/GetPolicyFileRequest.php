<?php

declare(strict_types=1);

namespace PhpClient\Tailscale\Requests\PolicyFile;

use PhpClient\Tailscale\Enums\AcceptHeader;
use Saloon\Enums\Method;
use Saloon\Http\Request;

use function array_filter;

/**
 * Get policy file.
 *
 * Retrieves the current policy file for the given tailnet; this includes the ACL along with the rules and tests
 * that have been defined.
 *
 * @see https://tailscale.com/api#tag/policyfile/GET/tailnet/%7Btailnet%7D/acl  Documentation
 * @version Relevant for 2024-08-30, API v2, OAS 3.1.0
 */
final class GetPolicyFileRequest extends Request
{
    protected Method $method = Method::GET;

    /**
     * @param string $tailnet The tailnet organization name.
     *
     * When specifying a tailnet in the API, you can:
     * - Provide a dash (-) to reference the default tailnet of the access token being used to make the API call.
     * This is the best option for most users.
     * - Provide the organization name found on the General Settings page of the Tailscale admin console.
     *
     * @param bool|null $details Request a detailed description of the tailnet policy file.
     *
     * @param AcceptHeader $acceptHeader Response is encoded as JSON or as HuJSON.
     */
    public function __construct(
        private readonly string $tailnet,
        private readonly ?bool $details = null,
        private readonly AcceptHeader $acceptHeader = AcceptHeader::JSON,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return "/tailnet/$this->tailnet/acl";
    }

    protected function defaultQuery(): array
    {
        return array_filter(array: [
            'details' => $this->details ? 'true' : null,
        ]);
    }

    protected function defaultHeaders(): array
    {
        if ($this->details || $this->acceptHeader === AcceptHeader::HUJSON) {
            return [
                // SaloonPHP do not provide ability to completely remove header from request,
                // if it already specified in connector default headers.
                // todo: Check if tailscale can process header with null value.
                'Accept' => null,
            ];
        }

        return [
            // Header "Accept: application/json" will be sent according to default headers in tailscale connector,
        ];
    }
}
