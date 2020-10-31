<?php

declare(strict_types=1);

namespace Akondas\Library\Common\Event;

interface DomainEventPublisher
{
    public function publish(DomainEvent $domainEvent): void;
}
