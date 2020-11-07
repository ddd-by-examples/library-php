<?php

declare(strict_types=1);

namespace Akondas\Library\Catalogue;

use InvalidArgumentException;

class Author
{
    private string $author;

    public function __construct(string $author)
    {
        if ($author === '') {
            throw new InvalidArgumentException('Author cannot be empty');
        }

        $this->author = $author;
    }

    public function author(): string
    {
        return $this->author;
    }
}
