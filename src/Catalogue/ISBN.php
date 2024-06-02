<?php

declare(strict_types=1);

namespace Akondas\Library\Catalogue;

use Isbn\Isbn as IsbnCode;

class ISBN
{
    private string $isbn;

    public function __construct(string $isbn)
    {
        if (!(new IsbnCode())->validation->isbn($isbn)) {
            throw new \InvalidArgumentException('Invalid ISBN');
        }

        $this->isbn = $isbn;
    }

    public function isbn(): string
    {
        return $this->isbn;
    }
}
