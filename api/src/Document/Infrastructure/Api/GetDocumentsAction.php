<?php

declare(strict_types=1);

namespace App\Document\Infrastructure\Api;

use App\Document\Application\Query\GetDocuments;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/documents', name: 'document.index', methods: ['GET'])]
final class GetDocumentsAction extends AbstractController
{
    public function __construct(
        private GetDocuments $query
    ) {
    }

    public function __invoke(Request $request): Response
    {
        $from = $request->query->getInt('from', 0);
        $limit = $request->query->getInt('limit', 20);
        $search = (string) $request->query->get('search');
        if ($search === '') {
            $search = null;
        }
        $categoryId = (string) $request->query->get('categoryId');
        if ($categoryId === '') {
            $categoryId = null;
        }

        $result = $this->query->execute($from, $limit, $search, $categoryId);

        return $this->json($result);
    }
}
