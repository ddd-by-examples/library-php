<?php

declare(strict_types=1);

namespace Akondas\Library\Lending\Patron\Domain;

final readonly class PatronInformation
{
    public function __construct(public PatronId $patronId, public PatronType $patronType)
    {
    }

    public function isRegular(): bool
    {
        return $this->patronType === PatronType::REGULAR;
    }
}
