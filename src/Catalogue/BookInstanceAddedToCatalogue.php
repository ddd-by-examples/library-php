<?php

declare(strict_types=1);

namespace Akondas\Library\Catalogue;

use Akondas\Library\Common\Event\DomainEvent;
use Akondas\Library\Common\UUID;
use DateTimeImmutable;

class BookInstanceAddedToCatalogue implements DomainEvent
{
    private UUID $eventId;

    private string $isbn;

    private BookType $bookType;

    private UUID $bookId;

    private DateTimeImmutable $when;
    
    private function __construct(UUID $eventId, string $isbn, BookType $bookType, UUID $bookId, DateTimeImmutable $when)
    {
        $this->eventId = $eventId;
        $this->isbn = $isbn;
        $this->bookType = $bookType;
        $this->bookId = $bookId;
        $this->when = $when;
    }

    public static function now(BookInstance $bookInstance): self
    {
        return new self(
            UUID::random(),
            $bookInstance->bookIsbn()->isbn(),
            $bookInstance->bookType(),
            $bookInstance->bookId()->bookId(),
            new DateTimeImmutable()
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

    public function when(): DateTimeImmutable
    {
        return $this->when;
    }
}
