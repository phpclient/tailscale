<?php

declare(strict_types=1);

namespace PhpClient\Tailscale\Requests\Devices;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Delete custom device posture attribute.
 *
 * Delete a posture attribute from the specified device.
 * This is only applicable to user-managed posture attributes in the custom namespace, which is indicated
 * by prefixing the attribute key with `custom:`.
 *
 * @see https://tailscale.com/api#tag/devices/DELETE/device/%7BdeviceId%7D/attributes/%7BattributeKey%7D  Documentation
 * @version Relevant for 2024-09-01, API v2, OAS 3.1.0
 */
final class DeleteCustomDevicePostureAttributeRequest extends Request
{
    protected Method $method = Method::DELETE;

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
     */
    public function __construct(
        private readonly string $deviceId,
        private readonly string $attributeKey,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return "/device/$this->deviceId/attributes/$this->attributeKey";
    }
}
