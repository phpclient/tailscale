<?php

declare(strict_types=1);

namespace PhpClient\Tailscale\Resources;

use PhpClient\Tailscale\Enums\AcceptHeader;
use PhpClient\Tailscale\Enums\AclPreviewTypeParameter;
use PhpClient\Tailscale\Requests\PolicyFile\GetPolicyFileRequest;
use PhpClient\Tailscale\Requests\PolicyFile\PreviewRuleMatchesRequest;
use PhpClient\Tailscale\Requests\PolicyFile\SetPolicyFileRequest;
use PhpClient\Tailscale\Requests\PolicyFile\ValidateAndTestPolicyFileRequest;
use Saloon\Exceptions\Request\FatalRequestException;
use Saloon\Exceptions\Request\RequestException;
use Saloon\Http\BaseResource;
use Saloon\Http\Response;

/**
 * @see https://tailscale.com/api#tag/policyfile  Documentation
 */
final class PolicyFileResource extends BaseResource
{
    /**
     * Get policy file.
     *
     * Retrieves the current policy file for the given tailnet; this includes the ACL along with the rules and tests
     * that have been defined.
     *
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
     *
     * @throws FatalRequestException|RequestException
     *
     * @see https://tailscale.com/api#tag/policyfile/GET/tailnet/%7Btailnet%7D/acl  Documentation
     * @version Relevant for 2024-08-30, API v2, OAS 3.1.0
     */
    public function getPolicyFile(
        string $tailnet,
        ?bool $details = null,
        AcceptHeader $acceptHeader = AcceptHeader::JSON,
    ): Response {
        return $this->connector->send(
            request: new GetPolicyFileRequest(
                tailnet: $tailnet,
                details: $details,
                acceptHeader: $acceptHeader,
            ),
        );
    }

    /**
     * Set policy file.
     *
     * Sets the ACL for the given tailnet.
     *
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
     *
     * @throws FatalRequestException|RequestException
     *
     * @see https://tailscale.com/api#tag/policyfile/POST/tailnet/%7Btailnet%7D/acl  Documentation
     * @version Relevant for 2024-08-30, API v2, OAS 3.1.0
     */
    public function setPolicyFile(
        string $tailnet,
        array $data,
        ?string $ifMatchEtag = null,
        AcceptHeader $acceptHeader = AcceptHeader::JSON,
    ): Response {
        return $this->connector->send(
            request: new SetPolicyFileRequest(
                tailnet: $tailnet,
                data: $data,
                ifMatchEtag: $ifMatchEtag,
                acceptHeader: $acceptHeader,
            ),
        );
    }

    /**
     * When given a user or IP port to match against, returns the tailnet policy rules that apply to that resource,
     * without saving the policy file to the server.
     *
     * @param string $tailnet The tailnet organization name.
     *
     * When specifying a tailnet in the API, you can:
     * - Provide a dash (-) to reference the default tailnet of the access token being used to make the API call.
     * This is the best option for most users.
     * - Provide the organization name found on the General Settings page of the Tailscale admin console.
     *
     * @param AclPreviewTypeParameter $type Specify for which type of resource (user or IP port) matching rules are to be fetched.
     *
     * @param string $previewFor The supplied policy file is queried with this parameter to determine which rules match.
     *
     * Values:
     * - If type is user, provide the email of a valid user with registered machines.
     * - If type is ipport, provide an IP address + port: 10.0.0.1:80.
     *
     * @param array $data Data for json body
     *
     * @throws FatalRequestException|RequestException
     *
     * @see https://tailscale.com/api#tag/policyfile/POST/tailnet/%7Btailnet%7D/acl/preview  Documentation
     * @version Relevant for 2024-08-30, API v2, OAS 3.1.0
     */
    public function previewRuleMatches(
        string $tailnet,
        AclPreviewTypeParameter $type,
        string $previewFor,
        array $data,
    ): Response {
        return $this->connector->send(
            request: new PreviewRuleMatchesRequest(
                tailnet: $tailnet,
                type: $type,
                previewFor: $previewFor,
                data: $data,
            ),
        );
    }


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
     * @throws FatalRequestException|RequestException
     *
     * @see https://tailscale.com/api#tag/policyfile/POST/tailnet/%7Btailnet%7D/acl/validate  Documentation
     * @version Relevant for 2024-08-30, API v2, OAS 3.1.0
     */
    public function validateAndTestPolicyFile(string $tailnet, array $data): Response
    {
        return $this->connector->send(
            request: new ValidateAndTestPolicyFileRequest(
                tailnet: $tailnet,
                data: $data,
            ),
        );
    }
}
