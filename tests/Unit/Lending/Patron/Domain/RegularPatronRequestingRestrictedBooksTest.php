<?php

declare(strict_types=1);

namespace Akondas\Library\Tests\Unit\Lending\Patron\Domain;

use Akondas\Library\Lending\Patron\Domain\HoldDuration;
use Akondas\Library\Lending\Patron\Domain\NumberOfDays;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class RegularPatronRequestingRestrictedBooksTest extends TestCase
{
    #[Test]
    public function regular_patron_cannot_place_on_hold_restricted_book(): void
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
