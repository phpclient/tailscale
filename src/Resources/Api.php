<?php

declare(strict_types=1);

namespace PhpClient\Tailscale\Resources;

use Saloon\Http\BaseResource;

final class Api extends BaseResource
{
    public function contactPreferences(): ContactPreferencesResource
    {
        return new ContactPreferencesResource(
            connector: $this->connector,
        );
    }

    public function deviceInvites(): DeviceInvitesResource
    {
        return new DeviceInvitesResource(
            connector: $this->connector,
        );
    }

    public function devicePosture(): DevicePostureResource
    {
        return new DevicePostureResource(
            connector: $this->connector,
        );
    }

    public function users(): UsersResource
    {
        return new UsersResource(
            connector: $this->connector,
        );
    }

    public function dns(): DnsResource
    {
        return new DnsResource(
            connector: $this->connector,
        );
    }

    public function webhooks(): WebhooksResource
    {
        return new WebhooksResource(
            connector: $this->connector,
        );
    }

    public function devices(): DevicesResource
    {
        return new DevicesResource(
            connector: $this->connector,
        );
    }

    public function tailnetSettings(): TailnetSettingsResource
    {
        return new TailnetSettingsResource(
            connector: $this->connector,
        );
    }

    public function logging(): LoggingResource
    {
        return new LoggingResource(
            connector: $this->connector,
        );
    }

    public function policyFile(): PolicyFileResource
    {
        return new PolicyFileResource(
            connector: $this->connector,
        );
    }

    public function keys(): KeysResource
    {
        return new KeysResource(
            connector: $this->connector,
        );
    }

    public function userInvites(): UserInvitesResource
    {
        return new UserInvitesResource(
            connector: $this->connector,
        );
    }
}
