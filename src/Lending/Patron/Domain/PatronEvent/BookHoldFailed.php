<?php

declare(strict_types=1);

namespace Akondas\Library\Lending\Patron\Domain\PatronEvent;

use Akondas\Library\Catalogue\BookId;
use Akondas\Library\Common\UUID;
use Akondas\Library\Lending\LibraryBranch\Domain\LibraryBranchId;
use Akondas\Library\Lending\Patron\Domain\HoldDuration;
use Akondas\Library\Lending\Patron\Domain\PatronEvent;
use Akondas\Library\Lending\Patron\Domain\PatronId;

final class BookHoldFailed implements PatronEvent
{
    private UUID $eventId;
    private PatronId $patronId;
    private string $reason;
    private BookId $bookId;
    private LibraryBranchId $libraryBranchId;
    private \DateTimeImmutable $when;
    private \DateTimeImmutable $holdFrom;
    private ?\DateTimeImmutable $holdTill;

    public function __construct(UUID $eventId, PatronId $patronId, string $reason, BookId $bookId, LibraryBranchId $libraryBranchId, \DateTimeImmutable $when, \DateTimeImmutable $holdFrom, ?\DateTimeImmutable $holdTill)
    {
        $this->eventId = $eventId;
        $this->patronId = $patronId;
        $this->reason = $reason;
        $this->bookId = $bookId;
        $this->libraryBranchId = $libraryBranchId;
        $this->when = $when;
        $this->holdFrom = $holdFrom;
        $this->holdTill = $holdTill;
    }

    public static function now(PatronId $patronId, string $reason, BookId $bookId, LibraryBranchId $libraryBranchId, HoldDuration $holdDuration): self
    {
        return new self(
            UUID::random(),
            $patronId,
            $reason,
            $bookId,
            $libraryBranchId,
            new \DateTimeImmutable(),
            $holdDuration->from(),
            $holdDuration->to()->getOrNull()
        );
    }

    public function patronId(): PatronId
    {
        return $this->patronId;
    }

    public function aggregateId(): UUID
    {
        return $this->patronId->patronId();
    }

    public function eventId(): UUID
    {
        return $this->eventId;
    }

    public function when(): \DateTimeImmutable
    {
        return $this->when;
    }

    public function reason(): string
    {
        return $this->reason;
    }

    public function bookId(): BookId
    {
        return $this->bookId;
    }

    public function libraryBranchId(): LibraryBranchId
    {
        return $this->libraryBranchId;
    }

    public function holdFrom(): \DateTimeImmutable
    {
        return $this->holdFrom;
    }

    public function holdTill(): ?\DateTimeImmutable
    {
        return $this->holdTill;
    }
}
