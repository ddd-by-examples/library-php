<?php

declare(strict_types=1);

namespace Akondas\Library\Catalogue;

use Akondas\Library\Common\UUID;

class BookInstance
{
    private ISBN $isbn;

    private BookId $bookId;

    private BookType $bookType;

    /**
     * BookInstance constructor.
     */
    private function __construct(ISBN $isbn, BookId $bookId, BookType $bookType)
    {
        $this->isbn = $isbn;
        $this->bookId = $bookId;
        $this->bookType = $bookType;
    }

    /**
     * @return BookInstance
     */
    public static function of(Book $book, BookType $bookType): self
    {
        return new self($book->bookIsbn(), new BookId(UUID::random()), $bookType);
    }

    public function bookIsbn(): ISBN
    {
        return $this->isbn;
    }

    public function bookId(): BookId
    {
        return $this->bookId;
    }

    public function bookType(): BookType
    {
        return $this->bookType;
    }
}
