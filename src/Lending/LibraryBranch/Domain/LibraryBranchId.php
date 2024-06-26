<?php

declare(strict_types=1);

namespace Akondas\Library\Lending\LibraryBranch\Domain;

use Akondas\Library\Common\UUID;

final readonly class LibraryBranchId
{
    public function __construct(public UUID $libraryBranchId)
    {
    }

    public static function fromString(string $bookId): self
    {
        return new self(new UUID($bookId));
    }
}
