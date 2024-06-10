<?php

declare(strict_types=1);

namespace Akondas\Library\Lending\Patron\Domain\PatronEvent;

use Akondas\Library\Common\UUID;
use Akondas\Library\Lending\Patron\Domain\PatronEvent;
use Akondas\Library\Lending\Patron\Domain\PatronId;

final readonly class MaximumNumberOnHoldsReached implements PatronEvent
{
    private function __construct(
        public UUID $eventId,
        public \DateTimeImmutable $when,
        public PatronId $patronId,
        public int $numberOfHolds
    ) {
    }

    public static function now(PatronId $patronId, int $numberOfHolds): self
    {
        return new self(
            UUID::random(),
            new \DateTimeImmutable(),
            $patronId,
            $numberOfHolds
        );
    }

    public function patronId(): PatronId
    {
        return $this->patronId;
    }

    public function eventId(): UUID
    {
        return $this->eventId;
    }

    public function aggregateId(): UUID
    {
        return $this->patronId->patronId;
    }

    public function when(): \DateTimeImmutable
    {
        return $this->when;
    }
}
