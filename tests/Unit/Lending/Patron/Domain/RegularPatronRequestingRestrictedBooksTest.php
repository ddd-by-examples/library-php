<?php

declare(strict_types=1);

namespace Akondas\Library\Tests\Unit\Lending\Patron\Domain;

use Akondas\Library\Lending\Patron\Domain\HoldDuration;
use PHPUnit\Framework\TestCase;

final class RegularPatronRequestingRestrictedBooksTest extends TestCase
{
    public function testARegularPatronCannotPlaceOnHoldRestrictedBook(): void
    {
        // when
        $hold = regularPatron()->placeOnHold(restrictedBook(), HoldDuration::openEnded());
        // then
        self::assertTrue($hold->isLeft());
        self::assertStringContainsString('Restricted book', $hold->getLeft()->reason());
    }
}
