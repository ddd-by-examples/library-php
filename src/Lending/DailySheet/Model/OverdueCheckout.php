<?php

declare(strict_types=1);

namespace Akondas\Library\Lending\DailySheet\Model;

use Akondas\Library\Catalogue\BookId;
use Akondas\Library\Lending\LibraryBranch\Domain\LibraryBranchId;
use Akondas\Library\Lending\Patron\Domain\PatronEvent\OverdueCheckoutRegistered;
use Akondas\Library\Lending\Patron\Domain\PatronId;

final readonly class OverdueCheckout
{
    public function __construct(public BookId $bookId, public PatronId $patronId, public LibraryBranchId $libraryBranchId)
    {
    }

    public function toEvent(): OverdueCheckoutRegistered
    {
        return OverdueCheckoutRegistered::now($this->patronId, $this->bookId, $this->libraryBranchId);
    }
}
