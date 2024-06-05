<?php

declare(strict_types=1);

namespace Akondas\Library\Lending\Patron\Domain\PlacingOnHoldPolicy;

final readonly class Rejection
{
    public function __construct(public string $reason)
    {
    }
}
