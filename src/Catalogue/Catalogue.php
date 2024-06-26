<?php

declare(strict_types=1);

namespace Akondas\Library\Catalogue;

use Akondas\Library\Common\Event\DomainEventPublisher;
use Akondas\Library\Common\Result\Result;
use Munus\Control\Option;
use Munus\Control\TryTo;

final readonly class Catalogue
{
    public function __construct(private CatalogueDatabase $database, private DomainEventPublisher $eventPublisher)
    {
    }

    /**
     * @return Option<Book>
     */
    public function getBook(string $isbn): Option
    {
        return $this->database->findByIsbn(new ISBN($isbn));
    }

    /**
     * @return TryTo<covariant Result>
     */
    public function addBook(string $isbn, string $title, string $author): TryTo
    {
        return TryTo::run(function () use ($isbn, $title, $author) {
            $book = Book::of($isbn, $title, $author);
            $this->database->saveBook($book);

            return Result::SUCCESS;
        });
    }

    /**
     * @return TryTo<covariant Result>
     */
    public function addBookInstance(string $isbn, BookType $bookType): TryTo
    {
        return TryTo::run(function () use ($isbn, $bookType) {
            return $this->database
                ->findByIsbn(new ISBN($isbn))
                ->map(fn (Book $book): BookInstance => BookInstance::of($book, $bookType))
                ->map(fn (BookInstance $bookInstance): BookInstance => $this->saveAndPublishEvent($bookInstance))
                ->map(fn (BookInstance $bookInstance): Result => Result::SUCCESS)
                ->getOrElse(Result::REJECTION); // @phpstan-ignore-line
        });
    }

    private function saveAndPublishEvent(BookInstance $bookInstance): BookInstance
    {
        $this->database->saveBookInstance($bookInstance);
        $this->eventPublisher->publish(BookInstanceAddedToCatalogue::now($bookInstance));

        return $bookInstance;
    }
}
