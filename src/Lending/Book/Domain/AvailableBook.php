<?php

declare(strict_types=1);

namespace Akondas\Library\Lending\Book\Domain;

use Akondas\Library\Catalogue\BookId;
use Akondas\Library\Catalogue\BookType;
use Akondas\Library\Common\Aggregate\Version;
use Akondas\Library\Lending\LibraryBranch\Domain\LibraryBranchId;

final readonly class AvailableBook implements Book
{
    public function __construct(
        public BookId $bookId,
        public BookType $bookType,
        public LibraryBranchId $libraryBranch,
        public Version $version)
    {
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

    public function isRestricted(): bool
    {
        return $this->bookType === BookType::RESTRICTED;
    }
}
