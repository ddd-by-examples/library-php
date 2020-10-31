<?php

declare(strict_types=1);

namespace Akondas\Library\Catalogue;

use Munus\Control\Option;

interface CatalogueDatabase
{
    public function saveBook(Book $book): Book;

    public function saveBookInstance(BookInstance $bookInstance): BookInstance;

    /**
     * @return Option<Book>
     */
    public function findByIsbn(ISBN $isbn): Option;
}
