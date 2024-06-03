<?php

declare(strict_types=1);

namespace Akondas\Library\Common\Aggregate;

final readonly class Version
{
    public function __construct(public int $version)
    {
    }

    public static function zero(): self
    {
        return new self(0);
    }
}
