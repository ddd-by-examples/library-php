<?php

declare(strict_types=1);

namespace Akondas\Library\Lending\DailySheet\Model;

use Akondas\Library\Lending\Patron\Domain\PatronEvent\BookHoldExpired;
use Munus\Collection\GenericList;
use Munus\Collection\Stream;

final readonly class HoldsToExpireSheet
{
    /**
     * @param GenericList<ExpiredHold> $expireHolds
     */
    public function __construct(public GenericList $expireHolds)
    {
    }

    /**
     * @return Stream<BookHoldExpired>
     */
    public function toStreamOfEvents(): Stream
    {
        return $this->expireHolds->toStream()->map(fn (ExpiredHold $eh) => $eh->toEvent());
    }

    public function count(): int
    {
        return $this->expireHolds->length();
    }
}
