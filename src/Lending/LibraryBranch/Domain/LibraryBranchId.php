<?php

declare(strict_types=1);

namespace Akondas\Library\Lending\LibraryBranch\Domain;

use Akondas\Library\Common\UUID;

final class LibraryBranchId
{
    private UUID $libraryBranchId;

    public function __construct(UUID $libraryBranchId)
    {
        $this->libraryBranchId = $libraryBranchId;
    }

    public function libraryBranchId(): UUID
    {
        return $this->libraryBranchId;
    }
}
