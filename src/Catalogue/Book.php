<?php

declare(strict_types=1);

namespace Akondas\Library\Catalogue;

class Book
{
    private ISBN $isbn;

    private Title $title;

    private Author $author;

    /**
     * Book constructor.
     */
    private function __construct(ISBN $isbn, Title $title, Author $author)
    {
        $this->isbn = $isbn;
        $this->title = $title;
        $this->author = $author;
    }

    /**
     * @return Book
     */
    public static function of(string $isbn, string $title, string $author): self
    {
        return new self(new ISBN($isbn), new Title($title), new Author($author));
    }

    public function bookIsbn(): ISBN
    {
        return $this->isbn;
    }

    public function getTitle(): Title
    {
        return $this->title;
    }

    public function getAuthor(): Author
    {
        return $this->author;
    }
}
