<?php

declare(strict_types=1);

namespace Akondas\Library\Lending\Patron\Domain;

use Akondas\Library\Lending\Book\Domain\AvailableBook;
use Akondas\Library\Lending\Patron\Domain\PatronEvent\BookHoldFailed;
use Akondas\Library\Lending\Patron\Domain\PatronEvent\BookPlacedOnHold;
use Munus\Control\Either;

final class Patron
{
    /**
     * @var PatronInformation
     */
    private $patron;

    public function __construct(PatronInformation $patron)
    {
        $this->patron = $patron;
    }

    /**
     * @return Either<BookHoldFailed,BookPlacedOnHold>
     */
    public function placeOnHold(AvailableBook $aBook, HoldDuration $holdDuration): Either
    {
        if ($aBook->isRestricted() && $this->patron->isRegular()) {
            return new Either\Left(BookHoldFailed::now($this->patron->patronId(), 'Restricted book', $aBook->bookId(), $aBook->libraryBranch(), $holdDuration));
        }

        return new Either\Right(BookPlacedOnHold::now($this->patron->patronId(), $aBook->bookId(), $aBook->bookType(), $aBook->libraryBranch(), $holdDuration));
    }
}
