<?php

declare(strict_types=1);

namespace Akondas\Library\Lending\Patron\Domain;

use Akondas\Library\Common\UUID;

final class PatronId
{
    private UUID $patronId;

    public function __construct(UUID $patronId)
    {
        $this->patronId = $patronId;
    }

    public function patronId(): UUID
    {
        return $this->patronId;
    }
}
