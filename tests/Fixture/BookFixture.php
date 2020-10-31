<?php

declare(strict_types=1);

use Akondas\Library\Catalogue\Book;
use Akondas\Library\Catalogue\BookId;
use Akondas\Library\Catalogue\BookType;
use Akondas\Library\Catalogue\ISBN;
use Akondas\Library\Common\Aggregate\Version;
use Akondas\Library\Common\UUID;
use Akondas\Library\Lending\Book\Domain\AvailableBook;
use Akondas\Library\Lending\LibraryBranch\Domain\LibraryBranchId;

function restrictedBook(): AvailableBook
{
    return new AvailableBook(anyBookId(), BookType::restricted(), anyBranch(), Version::zero());
}

function circulatingBook(): AvailableBook
{
    return new AvailableBook(anyBookId(), BookType::circulating(), anyBranch(), Version::zero());
}

function anyBookId(): BookId
{
    return new BookId(UUID::random());
}

function anyBranch(): LibraryBranchId
{
    return new LibraryBranchId(UUID::random());
}

define('DDD_ISBN_STR', (string) 9780321125217);

function dddISBN(): ISBN
{
    return new ISBN(DDD_ISBN_STR);
}

function dddBook(): Book
{
    return Book::of(DDD_ISBN_STR, 'Domain Driven Design', 'Eric Evans');
}
