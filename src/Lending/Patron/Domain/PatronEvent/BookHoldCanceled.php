<?php

declare(strict_types=1);

namespace Akondas\Library\Lending\Patron\Domain\PatronEvent;

use Akondas\Library\Catalogue\BookId;
use Akondas\Library\Common\UUID;
use Akondas\Library\Lending\LibraryBranch\Domain\LibraryBranchId;
use Akondas\Library\Lending\Patron\Domain\PatronEvent;
use Akondas\Library\Lending\Patron\Domain\PatronId;

final readonly class BookHoldCanceled implements PatronEvent
{
    private function __construct(
        public UUID $eventId,
        public \DateTimeImmutable $when,
        public PatronId $patronId,
        public BookId $bookId,
        public LibraryBranchId $libraryBranchId,
    ) {
    }

    public static function now(PatronId $patronId, BookId $bookId, LibraryBranchId $libraryBranchId): self
    {
        return new self(
            UUID::random(),
            new \DateTimeImmutable(),
            $patronId,
            $bookId,
            $libraryBranchId,
        );
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
        return $this->patronId->patronId;
    }

    public function when(): \DateTimeImmutable
    {
        return $this->when;
    }
}
