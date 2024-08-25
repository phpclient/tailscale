<?php

declare(strict_types=1);

namespace PhpClient\Tailscale\Requests;

use Saloon\Enums\Method;
use Saloon\Http\Request;

use function array_filter;
use function in_array;

final class ListTailnetDevices extends Request
{
    public const string QUERY_FIELDS_DEFAULT = 'default';
    public const string QUERY_FIELDS_ALL = 'all';

    protected Method $method = Method::GET;

    public function __construct(
        private $tailnet,
        private $fields = self::QUERY_FIELDS_DEFAULT,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return "/tailnet/$this->tailnet/devices";
    }

    protected function defaultQuery(): array
    {
        return array_filter(array: [
            'fields' => in_array(
                needle: $this->fields,
                haystack: [
                    self::QUERY_FIELDS_DEFAULT,
                    self::QUERY_FIELDS_ALL,
                ],
            ) ? $this->fields : null,
        ]);
    }
}
