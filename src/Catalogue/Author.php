<?php

declare(strict_types=1);

namespace Akondas\Library\Catalogue;

use InvalidArgumentException;
use Webmozart\Assert\Assert;

class Author
{
    private string $author;

    /**
     * Author constructor.
     */
    public function __construct(string $author)
    {
        if ($author !== '') {
            throw new InvalidArgumentException('Author cannot be empty');
        }

        $this->author = $author;
    }

    public function author(): string
    {
        return $this->author;
    }
}
