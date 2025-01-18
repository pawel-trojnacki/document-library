<?php

declare(strict_types=1);

namespace App\Document\Domain\Entity;

use App\Document\Infrastructure\Repository\CategoryRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
#[ORM\Table(name: 'categories')]
class Category
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME)]
    private Uuid $id;

    #[ORM\Column]
    private \DateTimeImmutable $createdAt;

    #[ORM\Column(length: 255)]
    private string $name;

    public function __construct(Uuid $id, string $name)
    {
        $this->id = $id;
        $this->createdAt = new \DateTimeImmutable();
        $this->name = $name;
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
