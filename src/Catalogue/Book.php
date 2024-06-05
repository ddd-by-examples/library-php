<?php

declare(strict_types=1);

namespace Akondas\Library\Catalogue;

final readonly class Book
{
    private function __construct(public ISBN $isbn, public Title $title, public Author $author)
    {
    }

    public static function of(string $isbn, string $title, string $author): self
    {
        return new self(new ISBN($isbn), new Title($title), new Author($author));
    }
}
