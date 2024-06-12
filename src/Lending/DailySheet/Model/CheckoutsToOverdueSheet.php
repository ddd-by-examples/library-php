<?php

declare(strict_types=1);

namespace Akondas\Library\Lending\DailySheet\Model;

use Akondas\Library\Lending\Patron\Domain\PatronEvent\OverdueCheckoutRegistered;
use Munus\Collection\GenericList;
use Munus\Collection\Stream;

final readonly class CheckoutsToOverdueSheet
{
    /**
     * @param GenericList<OverdueCheckout> $checkouts
     */
    public function __construct(public GenericList $checkouts)
    {
    }

    /**
     * @return Stream<OverdueCheckoutRegistered>
     */
    public function toStreamOfEvents(): Stream
    {
        return $this->checkouts->toStream()->map(fn (OverdueCheckout $oc) => $oc->toEvent());
    }

    public function count(): int
    {
        return $this->checkouts->length();
    }
}
