<?php

declare(strict_types=1);

namespace Akondas\Library\Lending\Book\Domain;

use Akondas\Library\Catalogue\BookId;
use Akondas\Library\Catalogue\BookType;

final readonly class BookInformation
{
    public function __construct(public BookId $bookId, public BookType $bookType)
    {
    }
}
