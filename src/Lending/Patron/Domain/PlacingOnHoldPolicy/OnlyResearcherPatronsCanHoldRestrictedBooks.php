<?php

declare(strict_types=1);

namespace Akondas\Library\Lending\Patron\Domain\PlacingOnHoldPolicy;

use Akondas\Library\Lending\Book\Domain\AvailableBook;
use Akondas\Library\Lending\Patron\Domain\HoldDuration;
use Akondas\Library\Lending\Patron\Domain\Patron;
use Akondas\Library\Lending\Patron\Domain\PlacingOnHoldPolicy;
use Munus\Control\Either;
use Munus\Control\Either\Left;
use Munus\Control\Either\Right;

final class OnlyResearcherPatronsCanHoldRestrictedBooks implements PlacingOnHoldPolicy
{
    /**
     * @return Either<Rejection,Allowance>
     */
    public function __invoke(AvailableBook $toHold, Patron $patron, HoldDuration $holdDuration): Either
    {
        if ($toHold->isRestricted() && $patron->isRegular()) {
            return new Left(new Rejection('Regular patrons cannot hold restricted books'));
        }

        return new Right(new Allowance());
    }
}
