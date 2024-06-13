<?php

declare(strict_types=1);

namespace Akondas\Library\Tests\Integration\Lending\DailySheet\Infrastructure;

use Akondas\Library\Catalogue\BookType;
use Akondas\Library\Common\UUID;
use Akondas\Library\Lending\DailySheet\Infrastructure\DbalDailySheet;
use Akondas\Library\Lending\Patron\Domain\PatronEvent\BookPlacedOnHold;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

#[CoversClass(DbalDailySheet::class)]
final class DbalDailySheetTest extends KernelTestCase
{
    private DbalDailySheet $dailySheet;

    protected function setUp(): void
    {
        $this->dailySheet = self::getContainer()->get(DbalDailySheet::class);
    }

    #[Test]
    public function handling_placed_on_hold_should_be_idempotent(): void
    {
        $currentNoOfExpiredHolds = $this->dailySheet->queryForHoldsToExpireSheet()->count();

        $event = $this->placedOnHold($this->aCloseEndedHoldTillYesterday());

        $this->dailySheet->handleBookPlacedOnHold($event);
        $this->dailySheet->handleBookPlacedOnHold($event);

        self::assertSame($currentNoOfExpiredHolds + 1, $this->dailySheet->queryForHoldsToExpireSheet()->count());
    }

    private function aCloseEndedHoldTillYesterday(): \DateTimeImmutable
    {
        return (new \DateTimeImmutable())->modify('-1 day');
    }

    private function placedOnHold(\DateTimeImmutable $till): BookPlacedOnHold
    {
        return new BookPlacedOnHold(
            UUID::random(),
            anyPatronId(),
            anyBookId(),
            BookType::RESTRICTED,
            anyBranch(),
            new \DateTimeImmutable(),
            $till->modify('-1 day'),
            $till
        );
    }
}
