<?php

declare(strict_types=1);

namespace Akondas\Library\Lending\Patron\Domain\PatronEvent;

use Akondas\Library\Catalogue\BookId;
use Akondas\Library\Catalogue\BookType;
use Akondas\Library\Common\UUID;
use Akondas\Library\Lending\LibraryBranch\Domain\LibraryBranchId;
use Akondas\Library\Lending\Patron\Domain\HoldDuration;
use Akondas\Library\Lending\Patron\Domain\PatronEvent;
use Akondas\Library\Lending\Patron\Domain\PatronId;

final class BookPlacedOnHold implements PatronEvent
{
    private UUID $eventId;
    private PatronId $patronId;
    private BookId $bookId;
    private BookType $bookType;
    private LibraryBranchId $libraryBranchId;
    private \DateTimeImmutable $holdFrom;
    private ?\DateTimeImmutable $holdTill;
    private \DateTimeImmutable $when;

    private function __construct(UUID $eventId, PatronId $patronId, BookId $bookId, BookType $bookType, LibraryBranchId $libraryBranchId, \DateTimeImmutable $when, \DateTimeImmutable $holdFrom, ?\DateTimeImmutable $holdTill)
    {
        $this->eventId = $eventId;
        $this->patronId = $patronId;
        $this->bookId = $bookId;
        $this->bookType = $bookType;
        $this->libraryBranchId = $libraryBranchId;
        $this->when = $when;
        $this->holdFrom = $holdFrom;
        $this->holdTill = $holdTill;
    }

    public static function now(PatronId $patronId, BookId $bookId, BookType $bookType, LibraryBranchId $libraryBranchId, HoldDuration $holdDuration): self
    {
        return new self(
            UUID::random(),
            $patronId,
            $bookId,
            $bookType,
            $libraryBranchId,
            new \DateTimeImmutable(),
            $holdDuration->from(),
            $holdDuration->to()->getOrNull()
        );
    }

    public function bookId(): BookId
    {
        return $this->bookId;
    }

    public function holdFrom(): \DateTimeImmutable
    {
        return $this->holdFrom;
    }

    public function holdTill(): ?\DateTimeImmutable
    {
        return $this->holdTill;
    }

    public function patronId(): PatronId
    {
        return $this->patronId;
    }

    public function eventId(): UUID
    {
        return $this->eventId;
    }

    public function aggregateId(): UUID
    {
        return $this->patronId->patronId();
    }

    public function when(): \DateTimeImmutable
    {
        return $this->when;
    }
}
