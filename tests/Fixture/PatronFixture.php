<?php

declare(strict_types=1);

use Akondas\Library\Common\UUID;
use Akondas\Library\Lending\Patron\Domain\Patron;
use Akondas\Library\Lending\Patron\Domain\PatronId;
use Akondas\Library\Lending\Patron\Domain\PatronInformation;
use Akondas\Library\Lending\Patron\Domain\PatronType;

function regularPatron(): Patron
{
    return new Patron(new PatronInformation(anyPatronId(), PatronType::regular()));
}

function anyPatronId(): PatronId
{
    return new PatronId(UUID::random());
}
