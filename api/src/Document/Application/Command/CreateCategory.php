<?php

declare(strict_types=1);

namespace App\Document\Application\Command;

use App\Document\Application\Dto\CategoryDto;
use App\Shared\Application\Command\Sync\Command;
use Symfony\Component\Uid\Uuid;

readonly class CreateCategory implements Command
{
    public Uuid $id;

    public function __construct(
        public string $name,
    ) {
        $this->id = Uuid::v7();
    }

    public static function fromDto(CategoryDto $dto): self
    {
        return new self($dto->name);
    }
}
