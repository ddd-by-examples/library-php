<?php

declare(strict_types=1);

namespace Akondas\Library\Common\Event;

use Akondas\Library\Common\UUID;

interface DomainEvent
{
    public function eventId(): UUID;

    public function aggregateId(): UUID;

    public function when(): \DateTimeImmutable;
}
