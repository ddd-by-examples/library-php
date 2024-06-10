<?php

declare(strict_types=1);

namespace Akondas\Library\Lending\Patron\Domain\PatronEvent;

use Akondas\Library\Catalogue\BookId;
use Akondas\Library\Catalogue\BookType;
use Akondas\Library\Common\UUID;
use Akondas\Library\Lending\LibraryBranch\Domain\LibraryBranchId;
use Akondas\Library\Lending\Patron\Domain\CheckoutDuration;
use Akondas\Library\Lending\Patron\Domain\PatronEvent;
use Akondas\Library\Lending\Patron\Domain\PatronId;

final readonly class BookCheckedOut implements PatronEvent
{
    private function __construct(
        public UUID $eventId,
        public PatronId $patronId,
        public BookId $bookId,
        public BookType $bookType,
        public LibraryBranchId $libraryBranchId,
        public \DateTimeImmutable $when,
        public \DateTimeImmutable $till,
    ) {
    }

    public static function now(PatronId $patronId, BookId $bookId, BookType $bookType, LibraryBranchId $libraryBranchId, CheckoutDuration $checkoutDuration): self
    {
        return new self(
            UUID::random(),
            $patronId,
            $bookId,
            $bookType,
            $libraryBranchId,
            new \DateTimeImmutable(),
            $checkoutDuration->to()
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
