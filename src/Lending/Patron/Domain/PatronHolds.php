<?php

declare(strict_types=1);

namespace Akondas\Library\Lending\Patron\Domain;

use Akondas\Library\Lending\Book\Domain\AvailableBook;
use Akondas\Library\Lending\Book\Domain\BookOnHold;
use Munus\Collection\Set;

final readonly class PatronHolds
{
    public const int MAX_NUMBER_OF_HOLDS = 5;

    /**
     * @param Set<Hold> $resourcesOnHold
     */
    public function __construct(public Set $resourcesOnHold)
    {
    }

    public function a(BookOnHold $bookOnHold): bool
    {
        return $this->resourcesOnHold->contains(new Hold($bookOnHold->bookId(), $bookOnHold->libraryBranch));
    }

    public function count(): int
    {
        return $this->resourcesOnHold->length();
    }

    public function maximumHoldsAfterHolding(AvailableBook $book): bool
    {
        return $this->count() + 1 === self::MAX_NUMBER_OF_HOLDS;
    }
}
