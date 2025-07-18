<?php

namespace SimpleShop\Controller\Api;

use SimpleShop\Entity\Product;
use SimpleShop\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api/products')]
class ProductApiController extends AbstractController
{
    public function __construct(
        private ProductRepository $productRepository,
        private SerializerInterface $serializer
    ) {}

    #[Route('', methods: ['GET'])]
    public function index(Request $request): JsonResponse
    {
        $page = $request->query->getInt('page', 1);
        $limit = $request->query->getInt('limit', 10);
        $category = $request->query->get('category');
        $search = $request->query->get('search');

        $products = $this->productRepository->findWithFilters($page, $limit, $category, $search);

        return $this->json([
            'data' => $products,
            'meta' => [
                'page' => $page,
                'limit' => $limit,
                'total' => $this->productRepository->countWithFilters($category, $search)
            ]
        ]);
    }

    #[Route('/{id}', methods: ['GET'])]
    public function show(Product $product): JsonResponse
    {
        return $this->json($product, 200, [], ['groups' => ['product_detail']]);
    }
}
