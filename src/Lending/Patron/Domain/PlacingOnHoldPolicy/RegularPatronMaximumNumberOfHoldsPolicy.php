<?php

declare(strict_types=1);

namespace Akondas\Library\Lending\Patron\Domain\PlacingOnHoldPolicy;

use Akondas\Library\Lending\Book\Domain\AvailableBook;
use Akondas\Library\Lending\Patron\Domain\HoldDuration;
use Akondas\Library\Lending\Patron\Domain\Patron;
use Akondas\Library\Lending\Patron\Domain\PatronHolds;
use Akondas\Library\Lending\Patron\Domain\PlacingOnHoldPolicy;
use Munus\Control\Either;
use Munus\Control\Either\Left;
use Munus\Control\Either\Right;

final readonly class RegularPatronMaximumNumberOfHoldsPolicy implements PlacingOnHoldPolicy
{
    public function __invoke(AvailableBook $toHold, Patron $patron, HoldDuration $holdDuration): Either
    {
        if ($patron->isRegular() && $patron->numberOfHolds() >= PatronHolds::MAX_NUMBER_OF_HOLDS) {
            return new Left(new Rejection('Regular patron cannot hold more books'));
        }

        return new Right(new Allowance());
    }
}
