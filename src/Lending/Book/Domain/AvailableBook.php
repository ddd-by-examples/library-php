<?php

declare(strict_types=1);

namespace Akondas\Library\Lending\Book\Domain;

use Akondas\Library\Catalogue\BookId;
use Akondas\Library\Catalogue\BookType;
use Akondas\Library\Common\Aggregate\Version;
use Akondas\Library\Lending\LibraryBranch\Domain\LibraryBranchId;

final class AvailableBook implements Book
{
    private BookId $bookId;
    private BookType $bookType;
    private LibraryBranchId $libraryBranch;
    private Version $version;

    public function __construct(BookId $bookId, BookType $bookType, LibraryBranchId $libraryBranch, Version $version)
    {
        $this->bookId = $bookId;
        $this->bookType = $bookType;
        $this->libraryBranch = $libraryBranch;
        $this->version = $version;
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

    public function libraryBranch(): LibraryBranchId
    {
        return $this->libraryBranch;
    }

    public function isRestricted(): bool
    {
        return $this->bookType === BookType::RESTRICTED;
    }
}
