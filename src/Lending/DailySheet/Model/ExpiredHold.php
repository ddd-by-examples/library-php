<?php

declare(strict_types=1);

namespace Akondas\Library\Lending\DailySheet\Model;

use Akondas\Library\Catalogue\BookId;
use Akondas\Library\Lending\LibraryBranch\Domain\LibraryBranchId;
use Akondas\Library\Lending\Patron\Domain\PatronEvent\BookHoldExpired;
use Akondas\Library\Lending\Patron\Domain\PatronId;

final readonly class ExpiredHold
{
    public function __construct(public BookId $bookId, public PatronId $patronId, public LibraryBranchId $libraryBranchId)
    {
    }

    public function toEvent(): BookHoldExpired
    {
        return BookHoldExpired::now($this->patronId, $this->bookId, $this->libraryBranchId);
    }
}
