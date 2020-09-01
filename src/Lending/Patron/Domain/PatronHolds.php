<?php

declare(strict_types=1);

namespace Akondas\Library\Lending\Patron\Domain;

use Akondas\Library\Lending\Book\Domain\AvailableBook;
use Akondas\Library\Lending\Book\Domain\BookOnHold;
use Munus\Collection\Set;

class PatronHolds
{
    public const MAX_NUMBER_OF_HOLDS = 5;

    /**
     * @var Set<Hold>
     */
    private Set $resourcesOnHold;

    /**
     * @param Set<Hold> $resourcesOnHold
     */
    public function __construct(Set $resourcesOnHold)
    {
        $this->resourcesOnHold = $resourcesOnHold;
    }

    public function a(BookOnHold $bookOnHold): bool
    {
        return $this->resourcesOnHold->contains(new Hold($bookOnHold->bookId(), $bookOnHold->libraryBranch()));
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
