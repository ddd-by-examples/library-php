<?php

declare(strict_types=1);

namespace Akondas\Library\Lending\Patron\Domain;

final readonly class NumberOfDays
{
    private function __construct(public int $days)
    {
        if ($days <= 0) {
            throw new \InvalidArgumentException('Cannot use negative integer or zero as number of days');
        }
    }

    public static function of(int $days): self
    {
        return new self($days);
    }

    public function isGreaterThan(int $days): bool
    {
        return $this->days > $days;
    }
}
