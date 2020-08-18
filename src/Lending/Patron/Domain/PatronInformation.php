<?php

declare(strict_types=1);

namespace Akondas\Library\Lending\Patron\Domain;

final class PatronInformation
{
    private PatronId $patronId;
    private PatronType $patronType;

    public function __construct(PatronId $patronId, PatronType $patronType)
    {
        $this->patronId = $patronId;
        $this->patronType = $patronType;
    }

    public function patronId(): PatronId
    {
        return $this->patronId;
    }

    public function patronType(): PatronType
    {
        return $this->patronType;
    }

    public function isRegular(): bool
    {
        return $this->patronType->equals(PatronType::regular());
    }
}
