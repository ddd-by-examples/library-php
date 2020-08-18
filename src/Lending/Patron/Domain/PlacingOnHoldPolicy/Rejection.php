<?php

declare(strict_types=1);

namespace Akondas\Library\Lending\Patron\Domain\PlacingOnHoldPolicy;

final class Rejection
{
    private string $reason;

    public function __construct(string $reason)
    {
        $this->reason = $reason;
    }

    public function reason(): string
    {
        return $this->reason;
    }
}
