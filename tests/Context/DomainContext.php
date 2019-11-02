<?php

declare(strict_types=1);

namespace Akondas\Library\Tests\Context;

use Akondas\Library\Lending\Patron\Domain\HoldDuration;
use Akondas\Library\Lending\Patron\Domain\NumberOfDays;
use Akondas\Library\Lending\Patron\Domain\PatronEvent\BookHoldFailed;
use Akondas\Library\Lending\Patron\Domain\PatronEvent\BookPlacedOnHold;
use Behat\Behat\Context\Context;
use Munus\Control\Either;

final class DomainContext implements Context
{
    /**
     * @var Either<BookHoldFailed,BookPlacedOnHold>her
     */
    private $hold;

    /**
     * @When a regular patron place on hold restricted book on :days days
     */
    public function aRegularPatronPlaceOnHoldRestrictedBookOnDays(int $days): void
    {
        $this->hold = regularPatron()->placeOnHold(restrictedBook(), HoldDuration::closeEnded(NumberOfDays::of($days)));
    }

    /**
     * @Then place on hold should fail with reason :reason
     */
    public function placeOnHoldShouldFailWithReason(string $reason)
    {
        \assertTrue($this->hold->isLeft());
    }
}
