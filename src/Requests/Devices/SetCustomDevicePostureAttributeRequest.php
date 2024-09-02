<?php

declare(strict_types=1);

namespace PhpClient\Tailscale\Requests\Devices;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * Set custom device posture attribute.
 *
 * Create or update a custom posture attribute on the specified device.
 * User-managed attributes must be in the custom namespace, which is indicated by prefixing the attribute key
 * with `custom:`.
 *
 * Custom device posture attributes are available for the Personal and Enterprise plans.
 *
 * @see https://tailscale.com/api#tag/devices/POST/device/%7BdeviceId%7D/attributes/%7BattributeKey%7D  Documentation
 * @version Relevant for 2024-09-01, API v2, OAS 3.1.0
 */
final class SetCustomDevicePostureAttributeRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    /**
     * @param string $deviceId ID of the device.
     * Using the device's nodeId is preferred, but its numeric id value can also be used.
     *
     * @param string $attributeKey The name of the posture attribute to set.
     * This must be prefixed with `custom:`.
     *
     * Keys have a maximum length of 50 characters including the namespace, and can only contain letters, numbers,
     * underscores, and colon.
     *
     * Keys are case-sensitive. Keys must be unique, but are checked for uniqueness in a case-insensitive manner.
     * For example, custom:MyAttribute and custom:myattribute cannot both be set within a single tailnet.
     *
     * All values for a given key need to be of the same type, which is determined when the first value is written
     * for a given key.
     * For example, custom:myattribute cannot have a numeric value (87) for one node and a string value ("78")
     * for another node within the same tailnet.
     *
     * @param array{
     *     value: mixed,
     * } $data Data for json body.
     *
     * A `value` can be either a string, number or boolean.
     *
     * A string value can have a maximum length of 50 characters, and can only contain letters, numbers, underscores,
     * and periods.
     *
     * A number value is an integer and must be a JSON safe number (up to 2^53 - 1).
     */
    public function __construct(
        private readonly string $deviceId,
        private readonly string $attributeKey,
        private readonly array $data,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return "/device/$this->deviceId/attributes/$this->attributeKey";
    }

    protected function defaultBody(): array
    {
        return $this->data;
    }
}
