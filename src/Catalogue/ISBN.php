<?php

declare(strict_types=1);

namespace Akondas\Library\Catalogue;

use Isbn\Isbn as IsbnCode;

final readonly class ISBN
{
    public function __construct(public string $isbn)
    {
        if (!(new IsbnCode())->validation->isbn($isbn)) {
            throw new \InvalidArgumentException('Invalid ISBN');
        }
    }
}
