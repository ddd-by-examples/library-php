<?php

declare(strict_types=1);

namespace Akondas\Library\Lending\Patron\Domain;

use Akondas\Library\Lending\Book\Domain\AvailableBook;
use Akondas\Library\Lending\Patron\Domain\PlacingOnHoldPolicy\Allowance;
use Akondas\Library\Lending\Patron\Domain\PlacingOnHoldPolicy\Rejection;
use Munus\Control\Either;

interface PlacingOnHoldPolicy
{
    /**
     * @return Either<Rejection,Allowance>
     */
    public function __invoke(AvailableBook $toHold, Patron $patron, HoldDuration $holdDuration): Either;
}
