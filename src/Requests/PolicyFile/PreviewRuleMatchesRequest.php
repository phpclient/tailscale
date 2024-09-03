<?php

declare(strict_types=1);

namespace PhpClient\Tailscale\Requests\PolicyFile;

use PhpClient\Tailscale\Enums\AclPreviewTypeParameter;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * When given a user or IP port to match against, returns the tailnet policy rules that apply to that resource,
 * without saving the policy file to the server.
 *
 * @see https://tailscale.com/api#tag/policyfile/POST/tailnet/%7Btailnet%7D/acl/preview  Documentation
 * @version Relevant for 2024-08-30, API v2, OAS 3.1.0
 */
final class PreviewRuleMatchesRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    /**
     * @param  string  $tailnet  The tailnet organization name.
     *
     * When specifying a tailnet in the API, you can:
     * - Provide a dash (-) to reference the default tailnet of the access token being used to make the API call.
     * This is the best option for most users.
     * - Provide the organization name found on the General Settings page of the Tailscale admin console.
     *
     * @param  AclPreviewTypeParameter  $type  Specify for which type of resource (user or IP port) matching rules are
     * to be fetched.
     *
     * @param  string  $previewFor  The supplied policy file is queried with this parameter to determine which rules match.
     *
     * Values:
     * - If type is user, provide the email of a valid user with registered machines.
     * - If type is ipport, provide an IP address + port: 10.0.0.1:80.
     *
     * @param  array  $data  Data for json body
     */
    public function __construct(
        private readonly string $tailnet,
        private readonly AclPreviewTypeParameter $type,
        private readonly string $previewFor,
        private readonly array $data,
    ) {}

    public function resolveEndpoint(): string
    {
        return "/tailnet/$this->tailnet/acl/preview";
    }

    protected function defaultQuery(): array
    {
        return [
            'type' => $this->type->value,
            'previewFor' => $this->previewFor,
        ];
    }

    protected function defaultBody(): array
    {
        return $this->data;
    }
}
