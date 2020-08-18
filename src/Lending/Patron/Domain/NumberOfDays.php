<?php

declare(strict_types=1);

namespace Akondas\Library\Lending\Patron\Domain;

final class NumberOfDays
{
    private int $days;

    private function __construct(int $days)
    {
        if ($days <= 0) {
            throw new \InvalidArgumentException('Cannot use negative integer or zero as number of days');
        }
        $this->days = $days;
    }

    public static function of(int $days): self
    {
        return new self($days);
    }

    public function days(): int
    {
        return $this->days;
    }

    public function isGreaterThan(int $days): bool
    {
        return $this->days > $days;
    }
}
