<?php

declare(strict_types=1);

namespace Akondas\Library\Tests\Context;

use Akondas\Library\Lending\Patron\Domain\HoldDuration;
use Akondas\Library\Lending\Patron\Domain\NumberOfDays;
use Akondas\Library\Lending\Patron\Domain\PatronEvent\BookHoldFailed;
use Akondas\Library\Lending\Patron\Domain\PatronEvent\BookPlacedOnHold;
use Behat\Behat\Context\Context;
use Munus\Control\Either;

use function PHPUnit\Framework\assertTrue;

final class DomainContext implements Context
{
    /**
     * @var ?Either<BookHoldFailed,BookPlacedOnHold>
     */
    private ?Either $hold = null;

    /**
     * @When a regular patron place on hold restricted book on :days days
     */
    public function aRegularPatronPlaceOnHoldRestrictedBookOnDays(int $days): void
    {
        $this->hold = regularPatron()->placeOnHold(restrictedBook(), HoldDuration::closeEnded(NumberOfDays::of($days)));
    }

    /**
     * @When a regular patron with :holds holds place on hold circulating book on :days days
     */
    public function aRegularPatronWithHoldsPlaceOnHold(int $holds, int $days): void
    {
        $this->hold = regularPatronWithHolds($holds)->placeOnHold(circulatingBook(), HoldDuration::closeEnded(NumberOfDays::of($days)));
    }

    /**
     * @Then place on hold should fail with reason :reason
     */
    public function placeOnHoldShouldFailWithReason(string $reason): void
    {
        assertTrue($this->hold && $this->hold->getLeft()->reason === $reason);
    }

    /**
     * @When a researcher patron with :holds holds place on hold circulating book
     */
    public function aResearcherPatronWithHoldsPlaceOnHoldCirculatingBook(int $holds): void
    {
        $this->hold = researcherPatronWithHolds($holds)->placeOnHold(circulatingBook(), HoldDuration::openEnded());
    }

    /**
     * @Then place on hold should succeed
     */
    public function placeOnHoldShouldSucceed(): void
    {
        assertTrue($this->hold && $this->hold->isRight());
    }
}
