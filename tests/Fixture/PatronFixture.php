<?php

declare(strict_types=1);

use Akondas\Library\Common\UUID;
use Akondas\Library\Lending\Patron\Domain\Hold;
use Akondas\Library\Lending\Patron\Domain\Patron;
use Akondas\Library\Lending\Patron\Domain\PatronHolds;
use Akondas\Library\Lending\Patron\Domain\PatronId;
use Akondas\Library\Lending\Patron\Domain\PatronInformation;
use Akondas\Library\Lending\Patron\Domain\PatronType;
use Akondas\Library\Lending\Patron\Domain\PlacingOnHoldPolicy;
use Akondas\Library\Lending\Patron\Domain\PlacingOnHoldPolicy\OnlyResearcherPatronsCanHoldRestrictedBooks;
use Akondas\Library\Lending\Patron\Domain\PlacingOnHoldPolicy\OnlyResearcherPatronsCanPlaceOpenEndedHolds;
use Akondas\Library\Lending\Patron\Domain\PlacingOnHoldPolicy\RegularPatronMaximumNumberOfHoldsPolicy;
use Munus\Collection\GenericList;
use Munus\Collection\Set;
use Munus\Collection\Stream;
use Munus\Collection\Stream\Collectors;

function regularPatron(): Patron
{
    return new Patron(
        new PatronInformation(anyPatronId(), PatronType::regular()),
        GenericList::of(
            new OnlyResearcherPatronsCanPlaceOpenEndedHolds(),
            new OnlyResearcherPatronsCanHoldRestrictedBooks()
        ),
        noHolds()
    );
}

function regularPatronWithHolds(int $numberOfHolds): Patron
{
    return new Patron(
        new PatronInformation(anyPatronId(), PatronType::regular()),
        GenericList::of(
            new OnlyResearcherPatronsCanPlaceOpenEndedHolds(),
            new OnlyResearcherPatronsCanHoldRestrictedBooks(),
            new RegularPatronMaximumNumberOfHoldsPolicy()
        ),
        booksOnHold($numberOfHolds)
    );
}

function researcherPatronWithPolicy(PatronId $patronId, PlacingOnHoldPolicy $placingOnHoldPolicy): Patron
{
    return patronWithPolicy($patronId, PatronType::researcher(), $placingOnHoldPolicy);
}

function researcherPatronWithHolds(int $numberOfHolds): Patron
{
    return new Patron(
        new PatronInformation(anyPatronId(), PatronType::researcher()),
        GenericList::of(
            new RegularPatronMaximumNumberOfHoldsPolicy()
        ),
        booksOnHold($numberOfHolds)
    );
}

function patronWithPolicy(PatronId $patronId, PatronType $patronType, PlacingOnHoldPolicy $placingOnHoldPolicy): Patron
{
    return new Patron(
        new PatronInformation($patronId, $patronType),
        GenericList::of($placingOnHoldPolicy),
        noHolds()
    );
}

function anyPatronId(): PatronId
{
    return new PatronId(UUID::random());
}

function noHolds(): PatronHolds
{
    /** @var Set<Hold> $holds */
    $holds = Set::empty();

    return new PatronHolds($holds);
}

function booksOnHold(int $numberOfHolds): PatronHolds
{
    if ($numberOfHolds <= 0) {
        return noHolds();
    }

    /** @var Set<Hold> $holds */
    $holds = Stream::range(1, $numberOfHolds)
        ->map(fn () => new Hold(anyBookId(), anyBranch()))
        ->collect(Collectors::toSet());

    return new PatronHolds($holds);
}
