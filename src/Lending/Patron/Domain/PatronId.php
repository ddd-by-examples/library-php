<?php

declare(strict_types=1);

namespace Akondas\Library\Lending\Patron\Domain;

use Akondas\Library\Common\UUID;

final readonly class PatronId
{
    public function __construct(public UUID $patronId)
    {
    }

    public static function fromString(string $bookId): self
    {
        return new self(new UUID($bookId));
    }
}
