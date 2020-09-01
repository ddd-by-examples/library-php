<?php

declare(strict_types=1);

namespace Akondas\Library\Lending\Book\Domain;

use Akondas\Library\Catalogue\BookId;
use Akondas\Library\Catalogue\BookType;
use Akondas\Library\Common\Aggregate\Version;
use Akondas\Library\Lending\LibraryBranch\Domain\LibraryBranchId;
use Akondas\Library\Lending\Patron\Domain\PatronId;

final class BookOnHold implements Book
{
    private BookId $bookId;

    private BookType $bookType;

    private LibraryBranchId $libraryBranch;

    private PatronId $byPatron;

    private \DateTimeImmutable $holdTill;

    private Version $version;

    /**
     * BookOnHold constructor.
     */
    public function __construct(BookId $bookId, BookType $bookType, LibraryBranchId $libraryBranch, PatronId $byPatron, \DateTimeImmutable $holdTill, Version $version)
    {
        $this->bookId = $bookId;
        $this->bookType = $bookType;
        $this->libraryBranch = $libraryBranch;
        $this->byPatron = $byPatron;
        $this->holdTill = $holdTill;
        $this->version = $version;
    }

    public function by(PatronId $patronId): bool
    {
        return $this->byPatron->patronId()->isEqual($patronId->patronId());
    }

    public function libraryBranch(): LibraryBranchId
    {
        return $this->libraryBranch;
    }

    public function bookId(): BookId
    {
        return $this->bookId;
    }

    public function bookType(): BookType
    {
        return $this->bookType;
    }

    public function version(): Version
    {
        return $this->version;
    }
}
