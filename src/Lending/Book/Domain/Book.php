<?php

declare(strict_types=1);

namespace Akondas\Library\Lending\Book\Domain;

use Akondas\Library\Catalogue\BookId;
use Akondas\Library\Catalogue\BookType;
use Akondas\Library\Common\Aggregate\Version;

interface Book
{
    public function bookId(): BookId;

    public function bookType(): BookType;

    public function version(): Version;
}
