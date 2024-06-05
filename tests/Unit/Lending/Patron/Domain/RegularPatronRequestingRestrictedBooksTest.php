<?php

declare(strict_types=1);

namespace Akondas\Library\Tests\Unit\Lending\Patron\Domain;

use Akondas\Library\Lending\Patron\Domain\HoldDuration;
use Akondas\Library\Lending\Patron\Domain\NumberOfDays;
use PHPUnit\Framework\TestCase;

final class RegularPatronRequestingRestrictedBooksTest extends TestCase
{
    public function testARegularPatronCannotPlaceOnHoldRestrictedBook(): void
    {
        // when
        $hold = regularPatron()->placeOnHold(restrictedBook(), HoldDuration::closeEnded(NumberOfDays::of(7)));
        // then
        self::assertTrue($hold->isLeft());
        self::assertStringContainsString(
            'Regular patrons cannot hold restricted books',
            $hold->getLeft()->reason
        );
    }
}
