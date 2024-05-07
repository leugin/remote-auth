<?php

namespace Leugin\RemoteAuth\Dto;

class Configuration
{
    public function __construct(
        public readonly ?string $model,
        public readonly ?string $login,
        public readonly ?string $me,
    ){}

    public static function makeByArray(array $data): self
    {
        return new self(
            model: $data['model'] ?? null,
            login: $data['urls']['login'] ?? null,
            me: $data['urls']['me'] ?? null,
        );
    }
}