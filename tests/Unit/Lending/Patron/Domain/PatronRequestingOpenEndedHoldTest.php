<?php

declare(strict_types=1);

namespace Akondas\Library\Tests\Unit\Lending\Patron\Domain;

use Akondas\Library\Lending\Patron\Domain\HoldDuration;
use Akondas\Library\Lending\Patron\Domain\PatronEvent\BookPlacedOnHold;
use Akondas\Library\Lending\Patron\Domain\PlacingOnHoldPolicy\OnlyResearcherPatronsCanPlaceOpenEndedHolds;
use PHPUnit\Framework\TestCase;

final class PatronRequestingOpenEndedHoldTest extends TestCase
{
    public function testResearcherPatronCanRequestCloseEndedHold(): void
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

    public function testRegularPatronCannotRequestOpenEndedHold(): void
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
