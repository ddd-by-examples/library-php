<?php

declare(strict_types=1);

namespace Akondas\Library\Lending\Patron\Domain;

use Akondas\Library\Lending\Book\Domain\AvailableBook;
use Akondas\Library\Lending\Patron\Domain\PatronEvent\BookHoldFailed;
use Akondas\Library\Lending\Patron\Domain\PatronEvent\BookPlacedOnHold;
use Akondas\Library\Lending\Patron\Domain\PlacingOnHoldPolicy\Rejection;
use Munus\Collection\GenericList;
use Munus\Control\Either;
use Munus\Control\Either\Left;
use Munus\Control\Either\Right;
use Munus\Control\Option;

final class Patron
{
    /**
     * @var PatronInformation
     */
    private $patron;

    /**
     * @var GenericList<PlacingOnHoldPolicy>
     */
    private $placingOnHoldPolicies;

    /**
     * @param GenericList<PlacingOnHoldPolicy> $placingOnHoldPolicies
     */
    public function __construct(PatronInformation $patron, GenericList $placingOnHoldPolicies)
    {
        $this->patron = $patron;
        $this->placingOnHoldPolicies = $placingOnHoldPolicies;
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
            return new Right(BookPlacedOnHold::now($this->patron->patronId(), $aBook->bookId(), $aBook->bookType(), $aBook->libraryBranch(), $holdDuration));
        }

        return new Left(BookHoldFailed::now($this->patron->patronId(), $rejection->get()->reason(), $aBook->bookId(), $aBook->libraryBranch(), $holdDuration));
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
