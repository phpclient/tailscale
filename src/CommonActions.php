<?php

declare(strict_types=1);

namespace PhpClient\Tailscale;

use PhpClient\Tailscale\Requests\ListTailnetDevices;

final readonly class CommonActions
{
    public function __construct(
        private TailscaleClient $client,
    ) {
    }

    public function listTailnetDevices(string $tailnet)
    {
        $request = new ListTailnetDevices(tailnet: $tailnet);
        $response = $this->client->send($request);

        $result = $response->dtoOrFail();

        return $result;
    }

    public function getDevice()
    {
    }

    public function deleteDevice()
    {
    }

    public function expireDeviceKey()
    {
    }

    public function listDeviceRoutes()
    {
    }

    public function setDeviceRoutes()
    {
    }

    public function authorizeDevice()
    {
    }

    public function setDeviceName()
    {
    }

    public function setDeviceTags()
    {
    }

    public function updateDeviceKey()
    {
        
    }

    public function setDeviceIp4Address()
    {

    }

    public function getDevicePostureAttributes()
    {

    }

    public function setCustomDevicePostureAttributes()
    {

    }

    public function deleteCustomDevicePostureAttributes()
    {

    }



}
