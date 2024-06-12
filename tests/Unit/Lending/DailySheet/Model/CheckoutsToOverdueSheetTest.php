<?php

declare(strict_types=1);

namespace Akondas\Library\Tests\Unit\Lending\DailySheet\Model;

use Akondas\Library\Lending\DailySheet\Model\CheckoutsToOverdueSheet;
use Akondas\Library\Lending\DailySheet\Model\OverdueCheckout;
use Munus\Collection\GenericList;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(CheckoutsToOverdueSheet::class)]
final class CheckoutsToOverdueSheetTest extends TestCase
{
    #[Test]
    public function it_will_transform_sheet_into_stream_of_OverdueCheckoutRegistered_events(): void
    {
        $sheet = new CheckoutsToOverdueSheet(GenericList::of(
            new OverdueCheckout($bookId = anyBookId(), $patronId = anyPatronId(), $libraryBranchId = anyBranch()),
            new OverdueCheckout($anotherBookId = anyBookId(), $anotherPatronId = anyPatronId(), $anotherLibraryBranchId = anyBranch())
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
