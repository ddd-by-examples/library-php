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

final class OnlyResearcherPatronsCanPlaceOpenEndedHolds implements PlacingOnHoldPolicy
{
    /**
     * @return Either<Rejection,Allowance>
     */
    public function __invoke(AvailableBook $toHold, Patron $patron, HoldDuration $holdDuration): Either
    {
        if ($patron->isRegular() && $holdDuration->isOpenEnded()) {
            return new Left(new Rejection('Regular patron cannot place open ended holds'));
        }

        return new Right(new Allowance());
    }
}
