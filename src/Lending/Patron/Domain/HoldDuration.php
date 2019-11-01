<?php

declare(strict_types=1);

namespace Akondas\Library\Lending\Patron\Domain;

use Munus\Control\Option;

final class HoldDuration
{
    /**
     * @var \DateTimeImmutable
     */
    private $from;

    /**
     * @var \DateTimeImmutable|null
     */
    private $to;

    private function __construct(\DateTimeImmutable $from, ?\DateTimeImmutable $to)
    {
        if ($to !== null && $to < $from) {
            throw new \InvalidArgumentException('Close-ended duration must be valid');
        }
        $this->from = $from;
        $this->to = $to;
    }

    public static function openEnded(): self
    {
        return new self(new \DateTimeImmutable(), null);
    }

    public static function closeEnded(NumberOfDays $days): self
    {
        $now = new \DateTimeImmutable();

        return new self($now, $now->modify(sprintf('+%s days', $days->days())));
    }

    public function from(): \DateTimeImmutable
    {
        return $this->from;
    }

    /**
     * @return Option<\DateTimeImmutable>
     */
    public function to(): Option
    {
        return Option::of($this->to);
    }

    public function isOpenEnded(): bool
    {
        return $this->to === null;
    }
}
