<?php

declare(strict_types=1);

namespace Akondas\Library\Catalogue;

use InvalidArgumentException;
use Isbn\Isbn as FaleIsbn;

class ISBN
{
    private FaleIsbn $faleIsbn;

    private string $isbn;

    public function __construct(string $isbn)
    {
        $this->faleIsbn = new FaleIsbn();

        if (!$this->faleIsbn->validation->isbn($isbn)) {
            throw new InvalidArgumentException('Invalid ISBN');
        }

        $this->isbn = $isbn;
    }

    public function isbn(): string
    {
        return $this->isbn;
    }
}
