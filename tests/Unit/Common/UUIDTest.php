<?php

declare(strict_types=1);

namespace Akondas\Library\Tests\Unit\Common;

use Akondas\Library\Common\UUID;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class UUIDTest extends TestCase
{
    #[Test]
    public function it_will_validate_uuid_string(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        new UUID('invalid string');
    }

    public function it_will_be_able_to_compare(): void
    {
        $uuid = UUID::random();

        self::assertTrue($uuid->isEqual($uuid));
    }
}