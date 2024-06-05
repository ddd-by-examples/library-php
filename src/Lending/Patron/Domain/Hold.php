<?php

declare(strict_types=1);

namespace Akondas\Library\Lending\Patron\Domain;

use Akondas\Library\Catalogue\BookId;
use Akondas\Library\Lending\LibraryBranch\Domain\LibraryBranchId;

final readonly class Hold
{
    public function __construct(public BookId $bookId, public LibraryBranchId $libraryBranchId)
    {
    }
}
