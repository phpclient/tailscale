<?php

declare(strict_types=1);

namespace PhpClient\Tailscale\Resources;

use PhpClient\Tailscale\Requests\Devices\AuthorizeDeviceRequest;
use PhpClient\Tailscale\Requests\Devices\DeleteCustomDevicePostureAttributeRequest;
use PhpClient\Tailscale\Requests\Devices\DeleteDeviceRequest;
use PhpClient\Tailscale\Requests\Devices\ExpireDeviceKeyRequest;
use PhpClient\Tailscale\Requests\Devices\GetDevicePostureAttributesRequest;
use PhpClient\Tailscale\Requests\Devices\GetDeviceRequest;
use PhpClient\Tailscale\Requests\Devices\ListDeviceRoutesRequest;
use PhpClient\Tailscale\Requests\Devices\ListTailnetDevicesRequest;
use PhpClient\Tailscale\Requests\Devices\SetCustomDevicePostureAttributeRequest;
use PhpClient\Tailscale\Requests\Devices\SetDeviceIpV4AddressRequest;
use PhpClient\Tailscale\Requests\Devices\SetDeviceNameRequest;
use PhpClient\Tailscale\Requests\Devices\SetDeviceRoutesRequest;
use PhpClient\Tailscale\Requests\Devices\SetDeviceTagsRequest;
use PhpClient\Tailscale\Requests\Devices\UpdateDeviceKeyRequest;
use Saloon\Exceptions\Request\FatalRequestException;
use Saloon\Exceptions\Request\RequestException;
use Saloon\Http\BaseResource;
use Saloon\Http\Response;

/**
 * @see https://tailscale.com/api#tag/devices  Documentation
 */
final class DevicesResource extends BaseResource
{
    /**
     * Lists the devices in a tailnet.
     *
     * @param  string  $tailnet  The tailnet organization name.
     *
     * When specifying a tailnet in the API, you can:
     * - Provide a dash (-) to reference the default tailnet of the access token being used to make the API call.
     * This is the best option for most users.
     * - Provide the organization name found on the General Settings page of the Tailscale admin console.
     *
     * @param  string|null  $fields  Optionally controls whether the response returns all fields or only a predefined
     * subset of fields.
     *
     * Currently, there are two supported options:
     * - all: return all fields in the response
     * - default: return all fields except:
     *     - enabledRoutes
     *     - advertisedRoutes
     *     - clientConnectivity
     *
     * If the fields parameter is not supplied, then the default (limited fields) option is used.
     *
     * @throws FatalRequestException|RequestException
     *
     * @see https://tailscale.com/api#tag/devices/GET/tailnet/%7Btailnet%7D/devices  Documentation
     * @version Relevant for 2024-09-01, API v2, OAS 3.1.0
     */
    public function listTailnetDevices(string $tailnet, ?string $fields = null): Response
    {
        return $this->connector->send(
            new ListTailnetDevicesRequest(
                tailnet: $tailnet,
                fields: $fields,
            ),
        );
    }

    /**
     * Retrieve the details for the specified device.
     *
     * @param  string  $deviceId  ID of the device.
     * Using the device's nodeId is preferred, but its numeric id value can also be used.
     *
     * @throws FatalRequestException|RequestException
     *
     * @see https://tailscale.com/api#tag/devices/GET/device/%7BdeviceId%7D  Documentation
     * @version Relevant for 2023-09-01, API v2, OAS 3.1.0
     */
    public function getDevice(string $deviceId): Response
    {
        return $this->connector->send(
            new GetDeviceRequest(
                deviceId: $deviceId,
            ),
        );
    }

    /**
     * Delete a device.
     *
     * Deletes the device from its tailnet. The device must belong to the requesting user's tailnet.
     * Deleting devices shared with the tailnet is not supported.
     *
     * @param  string  $deviceId  ID of the device.
     * Using the device's nodeId is preferred, but its numeric id value can also be used.
     *
     * @throws FatalRequestException|RequestException
     *
     * @see https://tailscale.com/api#tag/devices/DELETE/device/%7BdeviceId%7D  Documentation
     * @version Relevant for 2023-09-01, API v2, OAS 3.1.0
     */
    public function deleteDevice(string $deviceId): Response
    {
        return $this->connector->send(
            new DeleteDeviceRequest(
                deviceId: $deviceId,
            ),
        );
    }

    /**
     * Expire a device's key.
     *
     * Mark a device's node key as expired.
     * This will require the device to re-authenticate in order to connect to the tailnet.
     * The device must belong to the requesting user's tailnet.
     *
     * @param  string  $deviceId  ID of the device.
     * Using the device's nodeId is preferred, but its numeric id value can also be used.
     *
     * @throws FatalRequestException|RequestException
     *
     * @see https://tailscale.com/api#tag/devices/POST/device/%7BdeviceId%7D/expire  Documentation
     * @version Relevant for 2023-09-01, API v2, OAS 3.1.0
     */
    public function expireDeviceKey(string $deviceId): Response
    {
        return $this->connector->send(
            new ExpireDeviceKeyRequest(
                deviceId: $deviceId,
            ),
        );
    }

    /**
     * List device routes.
     *
     * Retrieve the list of subnet routes that a device is advertising, as well as those that are enabled for it.
     *
     * @param  string  $deviceId  ID of the device.
     * Using the device's nodeId is preferred, but its numeric id value can also be used.
     *
     * @throws FatalRequestException|RequestException
     *
     * @see https://tailscale.com/api#tag/devices/GET/device/%7BdeviceId%7D/routes  Documentation
     * @version Relevant for 2023-09-01, API v2, OAS 3.1.0
     */
    public function listDeviceRoutes(string $deviceId): Response
    {
        return $this->connector->send(
            new ListDeviceRoutesRequest(
                deviceId: $deviceId,
            ),
        );
    }

    /**
     * Set device routes.
     *
     * Set a device's enabled subnet routes by replacing the existing list of subnet routes with the supplied parameters.
     * Advertised routes cannot be set through the API, since they must be set directly on the device.
     *
     * @param  string  $deviceId  ID of the device.
     * Using the device's nodeId is preferred, but its numeric id value can also be used.
     *
     * @param  array{
     *     routes: string[],
     * }  $data  Data for json body.
     *
     * @throws FatalRequestException|RequestException
     *
     * @see https://tailscale.com/api#tag/devices/POST/device/%7BdeviceId%7D/routes  Documentation
     * @version Relevant for 2023-09-01, API v2, OAS 3.1.0
     */
    public function setDeviceRoutes(string $deviceId, array $data): Response
    {
        return $this->connector->send(
            new SetDeviceRoutesRequest(
                deviceId: $deviceId,
                data: $data,
            ),
        );
    }

    /**
     * Authorize device.
     *
     * This call marks a device as authorized or revokes its authorization for tailnets where device authorization
     * is required, according to the authorized field in the payload.
     *
     * @param  string  $deviceId  ID of the device.
     * Using the device's nodeId is preferred, but its numeric id value can also be used.
     *
     * @param  array{
     *     authorized: bool,
     * }  $data  Data for json body.
     *
     * @throws FatalRequestException|RequestException
     *
     * @see https://tailscale.com/api#tag/devices/POST/device/%7BdeviceId%7D/authorized  Documentation
     * @version Relevant for 2023-09-01, API v2, OAS 3.1.0
     */
    public function authorizeDevice(string $deviceId, array $data): Response
    {
        return $this->connector->send(
            new AuthorizeDeviceRequest(
                deviceId: $deviceId,
                data: $data,
            ),
        );
    }

    /**
     * Set device name.
     *
     * When a device is added to a tailnet, its Tailscale device name (also sometimes referred to as machine name)
     * is generated from its OS hostname. The device name is the canonical name for the device on your tailnet.
     *
     * Device name changes immediately get propogated through your tailnet, so be aware that any existing Magic DNS URLs
     * using the old name will no longer work.
     *
     * @param  string  $deviceId  ID of the device.
     * Using the device's nodeId is preferred, but its numeric id value can also be used.
     *
     * @param  array{
     *     name: bool,
     * }  $data  Data for json body.
     *
     * @throws FatalRequestException|RequestException
     *
     * @see https://tailscale.com/api#tag/devices/POST/device/%7BdeviceId%7D/name  Documentation
     * @version Relevant for 2023-09-01, API v2, OAS 3.1.0
     */
    public function setDeviceName(string $deviceId, array $data): Response
    {
        return $this->connector->send(
            new SetDeviceNameRequest(
                deviceId: $deviceId,
                data: $data,
            ),
        );
    }

    /**
     * Set device tags.
     *
     * Tags let you assign an identity to a device that is separate from human users, and use that identity as part of
     * an ACL to restrict access. Tags are similar to role accounts, but more flexible.
     *
     * Tags are created in the tailnet policy file by defining the tag and an owner of the tag. Once a device is tagged,
     * the tag is the owner of that device. A single node can have multiple tags assigned.
     *
     * Consult the policy file for your tailnet in the admin console for the list of tags that have been created for
     * your tailnet.
     *
     * @param  string  $deviceId  ID of the device.
     *  Using the device's nodeId is preferred, but its numeric id value can also be used.
     *
     * @param  array{
     *     tags: string[],
     * }  $data  Data for json body.
     *
     * @throws FatalRequestException|RequestException
     *
     * @see https://tailscale.com/api#tag/devices/POST/device/%7BdeviceId%7D/tags  Documentation
     * @version Relevant for 2023-09-01, API v2, OAS 3.1.0
     */
    public function setDeviceTags(string $deviceId, array $data): Response
    {
        return $this->connector->send(
            new SetDeviceTagsRequest(
                deviceId: $deviceId,
                data: $data,
            ),
        );
    }

    /**
     * Update device key/
     *
     * When a device is added to a tailnet, its key expiry is set according to the tailnet's key expiry setting.
     * If the key is not refreshed and expires, the device can no longer communicate with other devices in the tailnet.
     *
     * @param  string  $deviceId  ID of the device.
     * Using the device's nodeId is preferred, but its numeric id value can also be used.
     *
     * @param  array{
     *     keyExpiryDisabled: bool,
     * }  $data  Data for json body.
     *
     * @throws FatalRequestException|RequestException
     *
     * @see https://tailscale.com/api#tag/devices/POST/device/%7BdeviceId%7D/key  Documentation
     * @version Relevant for 2023-09-01, API v2, OAS 3.1.0
     */
    public function updateDeviceKey(string $deviceId, array $data): Response
    {
        return $this->connector->send(
            new UpdateDeviceKeyRequest(
                deviceId: $deviceId,
                data: $data,
            ),
        );
    }

    /**
     * Set device IPv4 address.
     *
     * When a device is added to a tailnet, its Tailscale IPv4 address is set at random either from the CGNAT range,
     * or a subset of the CGNAT range specified by an ip pool. This endpoint can be used to replace the existing IPv4
     * address with a specific value.
     *
     * This action will break any existing connections to this machine. You will need to reconnect to this machine using
     * the new IP address. You may also need to flush your DNS cache.
     *
     * @param  string  $deviceId  ID of the device.
     * Using the device's nodeId is preferred, but its numeric id value can also be used.
     *
     * @param  array{
     *     ipv4: bool,
     * }  $data  Data for json body.
     *
     * @throws FatalRequestException|RequestException
     *
     * @see https://tailscale.com/api#tag/devices/POST/device/%7BdeviceId%7D/ip  Documentation
     * @version Relevant for 2023-09-01, API v2, OAS 3.1.0
     */
    public function setDeviceIpV4Address(string $deviceId, array $data): Response
    {
        return $this->connector->send(
            new SetDeviceIpV4AddressRequest(
                deviceId: $deviceId,
                data: $data,
            ),
        );
    }

    /**
     * Get device posture attributes.
     *
     * Retrieve all posture attributes for the specified device.
     * This returns a JSON object of all the key-value pairs of posture attributes for the device.
     *
     * @param  string  $deviceId  ID of the device.
     * Using the device's nodeId is preferred, but its numeric id value can also be used.
     *
     * @throws FatalRequestException|RequestException
     *
     * @see https://tailscale.com/api#tag/devices/GET/device/%7BdeviceId%7D/attributes  Documentation
     * @version Relevant for 2023-09-01, API v2, OAS 3.1.0
     */
    public function getDevicePostureAttributes(string $deviceId): Response
    {
        return $this->connector->send(
            new GetDevicePostureAttributesRequest(
                deviceId: $deviceId,
            ),
        );
    }

    /**
     * Set custom device posture attribute.
     *
     * Create or update a custom posture attribute on the specified device.
     * User-managed attributes must be in the custom namespace, which is indicated by prefixing the attribute key
     * with `custom:`.
     *
     * Custom device posture attributes are available for the Personal and Enterprise plans.
     *
     * @param  string  $deviceId  ID of the device.
     * Using the device's nodeId is preferred, but its numeric id value can also be used.
     *
     * @param  string  $attributeKey  The name of the posture attribute to set.
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
     * @param  array{
     *     value: mixed,
     * }  $data  Data for json body.
     *
     * A `value` can be either a string, number or boolean.
     *
     * A string value can have a maximum length of 50 characters, and can only contain letters, numbers, underscores,
     * and periods.
     *
     * A number value is an integer and must be a JSON safe number (up to 2^53 - 1).
     *
     * @throws FatalRequestException|RequestException
     *
     * @see https://tailscale.com/api#tag/devices/POST/device/%7BdeviceId%7D/attributes/%7BattributeKey%7D  Documentation
     * @version Relevant for 2023-09-01, API v2, OAS 3.1.0
     */
    public function setCustomDevicePostureAttribute(string $deviceId, string $attributeKey, array $data): Response
    {
        return $this->connector->send(
            new SetCustomDevicePostureAttributeRequest(
                deviceId: $deviceId,
                attributeKey: $attributeKey,
                data: $data,
            ),
        );
    }

    /**
     * Delete custom device posture attribute.
     *
     * Delete a posture attribute from the specified device.
     * This is only applicable to user-managed posture attributes in the custom namespace, which is indicated
     * by prefixing the attribute key with `custom:`.
     *
     * @param  string  $deviceId  ID of the device.
     * Using the device's nodeId is preferred, but its numeric id value can also be used.
     *
     * @param  string  $attributeKey  The name of the posture attribute to set.
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
     * @throws FatalRequestException|RequestException
     *
     * @see https://tailscale.com/api#tag/devices/DELETE/device/%7BdeviceId%7D/attributes/%7BattributeKey%7D  Documentation
     * @version Relevant for 2023-09-01, API v2, OAS 3.1.0
     */
    public function deleteCustomDevicePostureAttribute(string $deviceId, string $attributeKey): Response
    {
        return $this->connector->send(
            new DeleteCustomDevicePostureAttributeRequest(
                deviceId: $deviceId,
                attributeKey: $attributeKey,
            ),
        );
    }
}
