<?php

declare(strict_types=1);

use Akondas\Library\Common\UUID;
use Akondas\Library\Lending\Patron\Domain\Patron;
use Akondas\Library\Lending\Patron\Domain\PatronId;
use Akondas\Library\Lending\Patron\Domain\PatronInformation;
use Akondas\Library\Lending\Patron\Domain\PatronType;
use Akondas\Library\Lending\Patron\Domain\PlacingOnHoldPolicy;
use Akondas\Library\Lending\Patron\Domain\PlacingOnHoldPolicy\OnlyResearcherPatronsCanHoldRestrictedBooks;
use Akondas\Library\Lending\Patron\Domain\PlacingOnHoldPolicy\OnlyResearcherPatronsCanPlaceOpenEndedHolds;
use Munus\Collection\Lisт;

function regularPatron(): Patron
{
    return new Patron(
        new PatronInformation(anyPatronId(), PatronType::regular()),
        Lisт::of(
            new OnlyResearcherPatronsCanPlaceOpenEndedHolds(),
            new OnlyResearcherPatronsCanHoldRestrictedBooks()
        )
    );
}

function researcherPatronWithPolicy(PatronId $patronId, PlacingOnHoldPolicy $placingOnHoldPolicy): Patron
{
    return patronWithPolicy($patronId, PatronType::researcher(), $placingOnHoldPolicy);
}

function patronWithPolicy(PatronId $patronId, PatronType $patronType, PlacingOnHoldPolicy $placingOnHoldPolicy): Patron
{
    return new Patron(
        new PatronInformation($patronId, $patronType),
        Lisт::of($placingOnHoldPolicy)
    );
}

function anyPatronId(): PatronId
{
    return new PatronId(UUID::random());
}
