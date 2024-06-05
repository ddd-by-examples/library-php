<?php

declare(strict_types=1);

namespace Akondas\Library\Catalogue;

final readonly class Title
{
    public function __construct(public string $title)
    {
        if ($title === '') {
            throw new \InvalidArgumentException('Title cannot be empty');
        }
    }
}
