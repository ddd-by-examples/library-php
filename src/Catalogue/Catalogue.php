<?php

declare(strict_types=1);

namespace Akondas\Library\Catalogue;

use Akondas\Library\Common\Event\DomainEventPublisher;
use Munus\Control\Option;
use Munus\Control\TryTo;

class Catalogue
{
    private CatalogueDatabase $database;
    private DomainEventPublisher $eventPublisher;

    public function __construct(CatalogueDatabase $database, DomainEventPublisher $eventPublisher)
    {
        $this->database = $database;
        $this->eventPublisher = $eventPublisher;
    }

    public function getBook(string $isbn): Option
    {
        return $this->database->findByIsbn(new ISBN($isbn));
    }

    public function addBook(string $isbn, string $title, string $author): TryTo
    {
        return TryTo::run(function () use ($isbn, $title, $author) {
            $book = Book::of($isbn, $title, $author);
            $this->database->saveBook($book);

            return 'Book added';
        });
    }

    public function addBookInstance(string $isbn, BookType $bookType): TryTo
    {
        return TryTo::run(function () use ($isbn, $bookType) {
            return $this->database
                ->findByIsbn(new ISBN($isbn))
                ->map(fn (Book $book): BookInstance => BookInstance::of($book, $bookType))
                ->map(fn (BookInstance $bookInstance): BookInstance => $this->saveAndPublishEvent($bookInstance))
                ->map(fn (BookInstance $bookInstance): string => 'Book instance added')
                ->getOrElse('Failed to adding instance');
        });
    }

    private function saveAndPublishEvent(BookInstance $bookInstance): BookInstance
    {
        $this->database->saveBookInstance($bookInstance);
        $this->eventPublisher->publish(BookInstanceAddedToCatalogue::now($bookInstance));

        return $bookInstance;
    }
}
