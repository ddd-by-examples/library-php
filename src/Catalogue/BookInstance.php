<?php

declare(strict_types=1);

namespace Akondas\Library\Catalogue;

final readonly class BookInstance
{
    private function __construct(public ISBN $isbn, public BookId $bookId, public BookType $bookType)
    {
    }

    public static function of(Book $book, BookType $bookType): self
    {
        return new self($book->isbn, BookId::random(), $bookType);
    }
}
