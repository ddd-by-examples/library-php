<?php

declare(strict_types=1);

namespace Akondas\Library\Lending\Patron\Domain;

use Akondas\Library\Common\Event\DomainEvent;

interface PatronEvent extends DomainEvent
{
    public function patronId(): PatronId;
}
