<?php

declare(strict_types=1);

namespace App\Document\Infrastructure\Api;

use App\Document\Application\Query\GetDocument;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/documents/{id}', name: 'document.show', methods: ['GET'])]
final class GetDocumentAction extends AbstractController
{
    public function __construct(
        private GetDocument $query,
    ) {
    }

    public function __invoke(string $id): Response
    {
        $document = $this->query->execute($id);
        if ($document === null) {
            return $this->json(null, Response::HTTP_NOT_FOUND);
        }

        return $this->json($document);
    }
}
