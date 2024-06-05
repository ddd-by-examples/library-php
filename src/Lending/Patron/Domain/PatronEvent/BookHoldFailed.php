<?php

declare(strict_types=1);

namespace Akondas\Library\Lending\Patron\Domain\PatronEvent;

use Akondas\Library\Catalogue\BookId;
use Akondas\Library\Common\UUID;
use Akondas\Library\Lending\LibraryBranch\Domain\LibraryBranchId;
use Akondas\Library\Lending\Patron\Domain\HoldDuration;
use Akondas\Library\Lending\Patron\Domain\PatronEvent;
use Akondas\Library\Lending\Patron\Domain\PatronId;

final readonly class BookHoldFailed implements PatronEvent
{
    public function __construct(
        public UUID $eventId,
        public PatronId $patronId,
        public string $reason,
        public BookId $bookId,
        public LibraryBranchId $libraryBranchId,
        public \DateTimeImmutable $when,
        public \DateTimeImmutable $holdFrom,
        public ?\DateTimeImmutable $holdTill)
    {
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
            $holdDuration->from,
            $holdDuration->to
        );
    }

    public function patronId(): PatronId
    {
        return $this->patronId;
    }

    public function aggregateId(): UUID
    {
        return $this->patronId->patronId;
    }

    public function eventId(): UUID
    {
        return $this->eventId;
    }

    public function when(): \DateTimeImmutable
    {
        return $this->when;
    }
}
