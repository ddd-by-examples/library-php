<?php

declare(strict_types=1);

namespace Akondas\Library\Lending\DailySheet\Model;

use Akondas\Library\Lending\Patron\Domain\PatronEvent\BookCheckedOut;
use Akondas\Library\Lending\Patron\Domain\PatronEvent\BookHoldCanceled;
use Akondas\Library\Lending\Patron\Domain\PatronEvent\BookHoldExpired;
use Akondas\Library\Lending\Patron\Domain\PatronEvent\BookPlacedOnHold;
use Akondas\Library\Lending\Patron\Domain\PatronEvent\BookReturned;

interface DailySheet
{
    public function queryForCheckoutsToOverdue(): CheckoutsToOverdueSheet;

    public function queryForHoldsToExpireSheet(): HoldsToExpireSheet;

    public function handleBookPlacedOnHold(BookPlacedOnHold $event): void;

    public function handleBookHoldCanceled(BookHoldCanceled $event): void;

    public function handleBookHoldExpired(BookHoldExpired $event): void;

    public function handleBookCheckedOut(BookCheckedOut $event): void;

    public function handleBookReturned(BookReturned $event): void;
}
