<?php

declare(strict_types=1);

namespace Akondas\Library\Common;

use Symfony\Component\Uid\Uuid as SymfonyUuid;

final class UUID
{
    private string $value;

    public function __construct(string $value)
    {
        if (!SymfonyUuid::isValid($value)) {
            throw new \InvalidArgumentException('Invalid UUID format');
        }

        $this->value = $value;
    }

    public static function random(): self
    {
        return new self(SymfonyUuid::v7()->toString());
    }

    public function __toString(): string
    {
        return $this->value;
    }

    public function isEqual(self $id): bool
    {
        return $this->value === $id->value;
    }
}
