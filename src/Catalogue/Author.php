<?php

declare(strict_types=1);

namespace Akondas\Library\Catalogue;

final readonly class Author
{
    public function __construct(public string $author)
    {
        if ($author === '') {
            throw new \InvalidArgumentException('Author cannot be empty');
        }
    }
}
