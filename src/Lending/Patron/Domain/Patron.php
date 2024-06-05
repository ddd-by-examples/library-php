<?php

declare(strict_types=1);

namespace Akondas\Library\Lending\Patron\Domain;

use Akondas\Library\Lending\Book\Domain\AvailableBook;
use Akondas\Library\Lending\Patron\Domain\PatronEvent\BookHoldFailed;
use Akondas\Library\Lending\Patron\Domain\PatronEvent\BookPlacedOnHold;
use Akondas\Library\Lending\Patron\Domain\PlacingOnHoldPolicy\Rejection;
use Munus\Collection\GenericList;
use Munus\Control\Either;
use Munus\Control\Option;

final readonly class Patron
{
    /**
     * @param GenericList<covariant PlacingOnHoldPolicy> $placingOnHoldPolicies
     */
    public function __construct(public PatronInformation $patron, public GenericList $placingOnHoldPolicies, public PatronHolds $patronHolds)
    {
    }

    public function isRegular(): bool
    {
        return $this->patron->isRegular();
    }

    /**
     * @return Either<BookHoldFailed,BookPlacedOnHold>
     */
    public function placeOnHold(AvailableBook $aBook, HoldDuration $holdDuration): Either
    {
        $rejection = $this->patronCanHold($aBook, $holdDuration);
        if ($rejection->isEmpty()) {
            return Either::right(BookPlacedOnHold::now($this->patron->patronId, $aBook->bookId(), $aBook->bookType(), $aBook->libraryBranch, $holdDuration));
        }

        return Either::left(BookHoldFailed::now($this->patron->patronId, $rejection->get()->reason, $aBook->bookId(), $aBook->libraryBranch, $holdDuration));
    }

    public function numberOfHolds(): int
    {
        return $this->patronHolds->count();
    }

    /**
     * @return Option<Rejection>
     */
    private function patronCanHold(AvailableBook $aBook, HoldDuration $holdDuration): Option
    {
        return $this->placingOnHoldPolicies
            ->toStream()
            ->map(function (PlacingOnHoldPolicy $policy) use ($aBook, $holdDuration): Either {return $policy($aBook, $this, $holdDuration); })
            ->find(function (Either $either): bool {return $either->isLeft(); })
            ->map(function (Either $either) {return $either->getLeft(); })
        ;
    }
}
