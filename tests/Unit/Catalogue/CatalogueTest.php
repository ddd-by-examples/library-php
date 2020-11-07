<?php

declare(strict_types=1);

namespace Akondas\Library\Tests\Unit\Catalogue;

use Akondas\Library\Catalogue\BookInstanceAddedToCatalogue;
use Akondas\Library\Catalogue\BookType;
use Akondas\Library\Catalogue\Catalogue;
use Akondas\Library\Catalogue\CatalogueDatabase;
use Akondas\Library\Catalogue\ISBN;
use Akondas\Library\Common\Event\DomainEventPublisher;
use Akondas\Library\Common\Result\Result;
use Exception;
use Munus\Control\Option;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class CatalogueTest extends TestCase
{
    /**
     * @var CatalogueDatabase|MockObject
     */
    private $database;
    /**
     * @var DomainEventPublisher|MockObject
     */
    private $eventPublisher;

    private Catalogue $catalogue;

    public function setUp(): void
    {
        parent::setUp();
        $this->database = self::createMock(CatalogueDatabase::class);
        $this->eventPublisher = self::createMock(DomainEventPublisher::class);
        $this->catalogue = new Catalogue($this->database, $this->eventPublisher);
    }

    public function testGetBookFromCatalogue(): void
    {
        // given
        $this->thereIsBookWith(DDD_ISBN_STR);
        // when
        $book = $this->catalogue->getBook(DDD_ISBN_STR);
        // then
        self::assertEquals(dddBook(), $book->get());
    }

    public function testPutBookToCatalogue(): void
    {
        // when
        $result = $this->catalogue->addBook(DDD_ISBN_STR, 'Domain Driven Design', 'Eric Evans');
        // then
        self::assertTrue($result->isSuccess());
        self::assertEquals(Result::SUCCESS(), $result->get());
    }

    /**
     * @psalm-suppress MixedMethodCall
     * @psalm-suppress PossiblyUndefinedMethod
     */
    public function testPutNewBookInstanceToCatalogue(): void
    {
        // given
        $this->thereIsBookWith(DDD_ISBN_STR);
        // and
        $this->eventPublisher
            ->expects(self::once())
            ->method('publish')
            ->with(self::isInstanceOf(BookInstanceAddedToCatalogue::class));
        // when
        $result = $this->catalogue->addBookInstance(DDD_ISBN_STR, BookType::restricted());
        // then
        self::assertTrue($result->isSuccess());
        self::assertEquals(Result::SUCCESS(), $result->get());
    }

    public function testItFailsOnAddingBookWhenDatabaseFails(): void
    {
        // given
        $this->databaseFails();
        // when
        $result = $this->catalogue->addBook(DDD_ISBN_STR, 'Domain Driven Design', 'Eric Evans');
        // then
        self::assertTrue($result->isFailure());
    }

    /**
     * @psalm-suppress MixedMethodCall
     * @psalm-suppress PossiblyUndefinedMethod
     */
    public function testItFailsOnAddingBookInstanceWhenDatabaseFails(): void
    {
        // given
        $this->databaseFails();
        // and
        $this->eventPublisher
            ->expects(self::never())
            ->method('publish');
        // when
        $result = $this->catalogue->addBookInstance(DDD_ISBN_STR, BookType::restricted());
        // then
        self::assertTrue($result->isFailure());
    }

    /**
     * @psalm-suppress MixedMethodCall
     * @psalm-suppress PossiblyUndefinedMethod
     */
    private function thereIsBookWith(string $isbn): void
    {
        $this->database->method('findByIsbn')->with(new ISBN($isbn))->willReturn(Option::of(dddBook()));
    }

    /**
     * @psalm-suppress MixedMethodCall
     * @psalm-suppress PossiblyUndefinedMethod
     */
    private function databaseFails(): void
    {
        $this->database->method('saveBook')->willThrowException(new Exception());
        $this->database->method('saveBookInstance')->willThrowException(new Exception());
    }
}
