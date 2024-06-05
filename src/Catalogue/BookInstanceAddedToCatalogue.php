<?php

declare(strict_types=1);

namespace Akondas\Library\Catalogue;

use Akondas\Library\Common\Event\DomainEvent;
use Akondas\Library\Common\UUID;

final readonly class BookInstanceAddedToCatalogue implements DomainEvent
{
    private function __construct(
        public UUID $eventId,
        public string $isbn,
        public BookType $bookType,
        public UUID $bookId,
        public \DateTimeImmutable $when
    ) {
    }

    public static function now(BookInstance $bookInstance): self
    {
        return new self(
            UUID::random(),
            $bookInstance->isbn->isbn,
            $bookInstance->bookType,
            $bookInstance->bookId->bookId,
            new \DateTimeImmutable()
        );
    }

    public function eventId(): UUID
    {
        return $this->eventId;
    }

    public function aggregateId(): UUID
    {
        return $this->bookId;
    }

    public function when(): \DateTimeImmutable
    {
        return $this->when;
    }
}
