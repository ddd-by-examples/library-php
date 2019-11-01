<?php

declare(strict_types=1);

namespace Akondas\Library\Common;

use Ramsey\Uuid\Uuid as RamseyUuid;

final class UUID
{
    /**
     * @var string
     */
    private $value;

    public function __construct(string $value)
    {
        if (!\preg_match('/^[0-9A-Fa-f]{8}-[0-9A-Fa-f]{4}-[0-9A-Fa-f]{4}-[0-9A-Fa-f]{4}-[0-9A-Fa-f]{12}$/', $value)) {
            throw new \InvalidArgumentException('Invalid UUID format');
        }

        $this->value = $value;
    }

    public static function random(): self
    {
        return new self(RamseyUuid::getFactory()->uuid4()->toString());
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
