<?php

declare(strict_types=1);

namespace Akondas\Library\Tests\Unit\Lending\Patron\Domain;

use Akondas\Library\Lending\Patron\Domain\HoldDuration;
use Akondas\Library\Lending\Patron\Domain\PatronEvent\BookPlacedOnHold;
use Akondas\Library\Lending\Patron\Domain\PlacingOnHoldPolicy\OnlyResearcherPatronsCanPlaceOpenEndedHolds;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class PatronRequestingOpenEndedHoldTest extends TestCase
{
    #[Test]
    public function researcher_patron_can_request_close_ended_hold(): void
    {
        // given
        $aBook = circulatingBook();
        $patronId = anyPatronId();
        $patron = researcherPatronWithPolicy($patronId, new OnlyResearcherPatronsCanPlaceOpenEndedHolds());
        // when
        $hold = $patron->placeOnHold($aBook, HoldDuration::openEnded());
        // then
        self::assertTrue($hold->isRight());
        $event = $hold->get();
        self::assertInstanceOf(BookPlacedOnHold::class, $event);
        self::assertEquals($patronId, $event->patronId());
        self::assertEquals($aBook->bookId(), $event->bookId);
        self::assertNull($event->holdTill);
    }

    #[Test]
    public function regular_patron_cannot_request_open_ended_hold(): void
    {
        // when
        $hold = regularPatron()->placeOnHold(circulatingBook(), HoldDuration::openEnded());
        // then
        self::assertTrue($hold->isLeft());
        self::assertStringContainsString(
            'Regular patron cannot place open ended holds',
            $hold->getLeft()->reason
        );
    }
}
