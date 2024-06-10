<?php

declare(strict_types=1);

namespace Akondas\Library\Tests\Unit\Lending\Patron\Domain;

use Akondas\Library\Lending\Patron\Domain\CheckoutDuration;
use Akondas\Library\Lending\Patron\Domain\NumberOfDays;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(CheckoutDuration::class)]
final class CheckoutDurationTest extends TestCase
{
    #[Test]
    public function it_will_allow_for_maximum_60_days(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        new CheckoutDuration(new \DateTimeImmutable(), NumberOfDays::of(61));
    }

    #[Test]
    public function it_will_calculate_to_timestamp(): void
    {
        $checkoutDuration = new CheckoutDuration(new \DateTimeImmutable('2024-06-10 10:10:10'), NumberOfDays::of(60));

        self::assertEquals(new \DateTimeImmutable('2024-08-09 10:10:10'), $checkoutDuration->to());
    }
}
