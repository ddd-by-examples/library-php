<?php

declare(strict_types=1);

namespace Akondas\Library\Catalogue;

use Webmozart\Assert\Assert;

class Title
{
    private string $title;

    /**
     * Title constructor.
     */
    public function __construct(string $title)
    {
        Assert::stringNotEmpty($title, 'Title cannot be empty');

        $this->title = $title;
    }

    public function getTitle(): string
    {
        return $this->title;
    }
}
