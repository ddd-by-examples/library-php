<?php

declare(strict_types=1);

namespace Akondas\Library\Catalogue;

use Akondas\Library\Common\UUID;

final readonly class BookId
{
    public function __construct(public UUID $bookId)
    {
    }

    public static function random(): self
    {
        return new self(UUID::random());
    }
}
