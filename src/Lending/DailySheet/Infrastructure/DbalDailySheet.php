<?php

declare(strict_types=1);

namespace Akondas\Library\Lending\DailySheet\Infrastructure;

use Akondas\Library\Catalogue\BookId;
use Akondas\Library\Lending\DailySheet\Model\CheckoutsToOverdueSheet;
use Akondas\Library\Lending\DailySheet\Model\DailySheet;
use Akondas\Library\Lending\DailySheet\Model\ExpiredHold;
use Akondas\Library\Lending\DailySheet\Model\HoldsToExpireSheet;
use Akondas\Library\Lending\LibraryBranch\Domain\LibraryBranchId;
use Akondas\Library\Lending\Patron\Domain\PatronEvent\BookCheckedOut;
use Akondas\Library\Lending\Patron\Domain\PatronEvent\BookHoldCanceled;
use Akondas\Library\Lending\Patron\Domain\PatronEvent\BookHoldExpired;
use Akondas\Library\Lending\Patron\Domain\PatronEvent\BookPlacedOnHold;
use Akondas\Library\Lending\Patron\Domain\PatronEvent\BookReturned;
use Akondas\Library\Lending\Patron\Domain\PatronId;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Types\Types;
use Munus\Collection\GenericList;
use Symfony\Component\Clock\ClockInterface;

final readonly class DbalDailySheet implements DailySheet
{
    public function __construct(private Connection $connection, private ClockInterface $clock)
    {
    }

    public function queryForCheckoutsToOverdue(): CheckoutsToOverdueSheet
    {
        return new CheckoutsToOverdueSheet(GenericList::empty());
    }

    public function queryForHoldsToExpireSheet(): HoldsToExpireSheet
    {
        /** @var array<array{book_id: string, hold_by_patron_id: string, hold_at_branch: string}> $rows */
        $rows = $this->connection->fetchAllAssociative('SELECT h.book_id, h.hold_by_patron_id, h.hold_at_branch FROM holds_sheet h WHERE h.status = :status and h.hold_till <= :till', [
            'status' => 'ACTIVE',
            'till' => $this->clock->now(),
        ], [
            'till' => Types::DATETIME_IMMUTABLE,
        ]);

        return new HoldsToExpireSheet(GenericList::ofAll(array_map(
            fn (array $row) => new ExpiredHold(BookId::fromString($row['book_id']), PatronId::fromString($row['hold_by_patron_id']), LibraryBranchId::fromString($row['hold_at_branch'])),
            $rows
        )));
    }

    public function handleBookPlacedOnHold(BookPlacedOnHold $event): void
    {
        $this->connection->executeQuery(
            'INSERT INTO holds_sheet (book_id, status, hold_event_id, hold_by_patron_id, hold_at, hold_till, hold_at_branch) VALUES (:book_id, :status, :hold_event_id, :hold_by_patron_id, :hold_at, :hold_till, :hold_at_branch) ON CONFLICT (hold_event_id) DO NOTHING',
            [
                'book_id' => (string) $event->bookId->bookId,
                'status' => 'ACTIVE',
                'hold_event_id' => (string) $event->eventId,
                'hold_by_patron_id' => (string) $event->patronId->patronId,
                'hold_at' => $event->when,
                'hold_till' => $event->holdTill,
                'hold_at_branch' => (string) $event->libraryBranchId->libraryBranchId,
            ], [
                'hold_at' => Types::DATETIME_IMMUTABLE,
                'hold_till' => Types::DATETIME_IMMUTABLE,
            ]
        );
    }

    public function handleBookHoldCanceled(BookHoldCanceled $event): void
    {
        // TODO: Implement handleBookHoldCanceled() method.
    }

    public function handleBookHoldExpired(BookHoldExpired $event): void
    {
        // TODO: Implement handleBookHoldExpired() method.
    }

    public function handleBookCheckedOut(BookCheckedOut $event): void
    {
        // TODO: Implement handleBookCheckedOut() method.
    }

    public function handleBookReturned(BookReturned $event): void
    {
        // TODO: Implement handleBookReturned() method.
    }
}
