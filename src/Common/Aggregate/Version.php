<?php

declare(strict_types=1);

namespace Akondas\Library\Common\Aggregate;

final class Version
{
    /**
     * @var int
     */
    private $version;

    public function __construct(int $version)
    {
        $this->version = $version;
    }

    public static function zero(): self
    {
        return new self(0);
    }
}
