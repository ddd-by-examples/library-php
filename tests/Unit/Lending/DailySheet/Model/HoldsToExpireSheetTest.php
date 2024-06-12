<?php

declare(strict_types=1);

namespace Akondas\Library\Tests\Unit\Lending\DailySheet\Model;

use Akondas\Library\Lending\DailySheet\Model\ExpiredHold;
use Akondas\Library\Lending\DailySheet\Model\HoldsToExpireSheet;
use Munus\Collection\GenericList;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(HoldsToExpireSheet::class)]
final class HoldsToExpireSheetTest extends TestCase
{
    #[Test]
    public function it_will_transform_sheet_into_stream_of_BookHoldExpired_events(): void
    {
        $sheet = new HoldsToExpireSheet(GenericList::of(
            new ExpiredHold($bookId = anyBookId(), $patronId = anyPatronId(), $libraryBranchId = anyBranch()),
            new ExpiredHold($anotherBookId = anyBookId(), $anotherPatronId = anyPatronId(), $anotherLibraryBranchId = anyBranch())
        ));

        $events = $sheet->toStreamOfEvents()->toArray();

        self::assertTrue($events[0]->bookId->bookId->isEqual($bookId->bookId));
        self::assertTrue($events[0]->patronId->patronId->isEqual($patronId->patronId));
        self::assertTrue($events[0]->libraryBranchId->libraryBranchId->isEqual($libraryBranchId->libraryBranchId));

        self::assertTrue($events[1]->bookId->bookId->isEqual($anotherBookId->bookId));
        self::assertTrue($events[1]->patronId->patronId->isEqual($anotherPatronId->patronId));
        self::assertTrue($events[1]->libraryBranchId->libraryBranchId->isEqual($anotherLibraryBranchId->libraryBranchId));
    }
}
