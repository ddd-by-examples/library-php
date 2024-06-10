<?php

declare(strict_types=1);

namespace Akondas\Library\Lending\Book\Domain;

use Akondas\Library\Catalogue\BookId;
use Akondas\Library\Catalogue\BookType;
use Akondas\Library\Common\Aggregate\Version;
use Akondas\Library\Lending\LibraryBranch\Domain\LibraryBranchId;
use Akondas\Library\Lending\Patron\Domain\PatronId;

final readonly class BookOnHold implements Book
{
    public function __construct(
        public BookInformation $bookInformation,
        public LibraryBranchId $libraryBranch,
        public PatronId $byPatron,
        public \DateTimeImmutable $holdTill,
        public Version $version)
    {
    }

    public function by(PatronId $patronId): bool
    {
        return $this->byPatron->patronId->isEqual($patronId->patronId);
    }

    public function bookId(): BookId
    {
        return $this->bookInformation->bookId;
    }

    public function bookType(): BookType
    {
        return $this->bookInformation->bookType;
    }

    public function version(): Version
    {
        return $this->version;
    }
}
