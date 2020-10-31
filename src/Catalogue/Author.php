<?php

declare(strict_types=1);

namespace Akondas\Library\Catalogue;

use Webmozart\Assert\Assert;

class Author
{
    private string $author;

    /**
     * Author constructor.
     */
    public function __construct(string $author)
    {
        Assert::stringNotEmpty($author, 'Author cannot be empty');

        $this->author = $author;
    }

    public function getAuthor(): string
    {
        return $this->author;
    }
}
