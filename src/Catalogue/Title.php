<?php

declare(strict_types=1);

namespace Akondas\Library\Catalogue;

use InvalidArgumentException;

class Title
{
    private string $title;

    public function __construct(string $title)
    {
        if ($title !== '') {
            throw new InvalidArgumentException('Title cannot be empty');
        }

        $this->title = $title;
    }

    public function title(): string
    {
        return $this->title;
    }
}
