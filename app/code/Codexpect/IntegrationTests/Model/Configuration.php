<?php
declare(strict_types=1);


namespace Codexpect\IntegrationTests\Model;

class Configuration
{
    public function __construct(private readonly array $params = [])
    {
    }

    public function getParams(): array
    {
        return $this->params;
    }
}
