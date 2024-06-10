<?php

declare(strict_types=1);

namespace Akondas\Library\Lending\Patron\Domain\PatronEvent;

use Akondas\Library\Common\UUID;
use Akondas\Library\Lending\Patron\Domain\PatronEvent;
use Akondas\Library\Lending\Patron\Domain\PatronId;
use Akondas\Library\Lending\Patron\Domain\PatronType;

final readonly class PatronCreated implements PatronEvent
{
    private function __construct(
        public UUID $eventId,
        public PatronId $patronId,
        public \DateTimeImmutable $when,
        public PatronType $patronType
    ) {
    }

    public static function now(PatronId $patronId, PatronType $patronType): self
    {
        return new self(
            UUID::random(),
            $patronId,
            new \DateTimeImmutable(),
            $patronType
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
