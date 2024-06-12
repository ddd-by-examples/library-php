<?php

declare(strict_types=1);

namespace Akondas\Library\Lending\Patron\Domain\PatronEvent;

use Akondas\Library\Catalogue\BookId;
use Akondas\Library\Catalogue\BookType;
use Akondas\Library\Common\UUID;
use Akondas\Library\Lending\LibraryBranch\Domain\LibraryBranchId;
use Akondas\Library\Lending\Patron\Domain\PatronEvent;
use Akondas\Library\Lending\Patron\Domain\PatronId;

final readonly class BookReturned implements PatronEvent
{
    public function __construct(
        public UUID $eventId,
        public \DateTimeImmutable $when,
        public PatronId $patronId,
        public BookId $bookId,
        public BookType $bookType,
        public LibraryBranchId $libraryBranchId,
    ) {
    }

    public static function now(PatronId $patronId, BookId $bookId, BookType $bookType, LibraryBranchId $libraryBranchId): self
    {
        return new self(
            UUID::random(),
            new \DateTimeImmutable(),
            $patronId,
            $bookId,
            $bookType,
            $libraryBranchId,
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
