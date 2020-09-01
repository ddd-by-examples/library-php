<?php

declare(strict_types=1);

namespace Akondas\Library\Lending\Patron\Domain;

use Akondas\Library\Catalogue\BookId;
use Akondas\Library\Lending\LibraryBranch\Domain\LibraryBranchId;

class Hold
{
    private BookId $bookId;
    private LibraryBranchId $libraryBranchId;

    public function __construct(BookId $bookId, LibraryBranchId $libraryBranchId)
    {
        $this->bookId = $bookId;
        $this->libraryBranchId = $libraryBranchId;
    }

    public function bookId(): BookId
    {
        return $this->bookId;
    }

    public function libraryBranchId(): LibraryBranchId
    {
        return $this->libraryBranchId;
    }
}
