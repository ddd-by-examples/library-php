<?php

declare(strict_types=1);

namespace Akondas\Library\Lending\Patron\Domain;

final readonly class HoldDuration
{
    private function __construct(public \DateTimeImmutable $from, public ?\DateTimeImmutable $to)
    {
        if ($to !== null && $to < $from) {
            throw new \InvalidArgumentException('Close-ended duration must be valid');
        }
    }

    public static function openEnded(): self
    {
        return new self(new \DateTimeImmutable(), null);
    }

    public static function closeEnded(NumberOfDays $days): self
    {
        $now = new \DateTimeImmutable();

        return new self($now, $now->modify(sprintf('+%s days', $days->days)));
    }

    public function isOpenEnded(): bool
    {
        return $this->to === null;
    }
}
