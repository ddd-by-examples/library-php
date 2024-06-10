<?php

declare(strict_types=1);

namespace Akondas\Library\Lending\Patron\Domain;

final readonly class CheckoutDuration
{
    public const int MAX_CHECKOUT_DURATION = 60;

    public function __construct(public \DateTimeImmutable $from, public NumberOfDays $noOfDays)
    {
        if ($this->noOfDays->isGreaterThan(self::MAX_CHECKOUT_DURATION)) {
            throw new \InvalidArgumentException(sprintf('Cannot checkout for more than %s days!', self::MAX_CHECKOUT_DURATION));
        }
    }

    public static function maxDuration(): self
    {
        return new self(new \DateTimeImmutable(), NumberOfDays::of(self::MAX_CHECKOUT_DURATION));
    }

    public function to(): \DateTimeImmutable
    {
        return $this->from->modify(sprintf('+%d days', $this->noOfDays->days));
    }
}
