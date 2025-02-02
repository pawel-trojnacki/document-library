<?php

declare(strict_types=1);

namespace App\Document\Infrastructure\Api;

use App\Document\Application\Query\GetCategories;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/categories', name: 'categories.index', methods: ['GET'])]
final class GetCategoriesAction extends AbstractController
{
    public function __construct(
        private GetCategories $query,
    ) {
    }

    public function __invoke(): Response
    {
        $categories = $this->query->execute();
        return $this->json($categories);
    }
}
