<?php

declare(strict_types=1);

namespace Akondas\Library\Catalogue;

use Akondas\Library\Common\UUID;

final class BookId
{
    /**
     * @var UUID
     */
    private $bookId;

    public function __construct(UUID $bookId)
    {
        $this->bookId = $bookId;
    }

    public function bookId(): UUID
    {
        return $this->bookId;
    }
}
