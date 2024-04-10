<?php

namespace App\Controller;

use App\Entity\Product;
use App\Service\CartService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('api/product')]
class ProductController extends AbstractController
{
    #[Route('/add/{id}', name: 'app_product_add')]
    public function index(CartService $service,Product $product): Response
    {
        $service->addProduct($product,1);
        $response = [
            "content"=>"Vous avez bien ajouté ".$product->getName()." au panier",
            "code"=>200
        ];
        return $this->json($response,200,[],["groups"=>"forOrderSerializing"]);
    }

    #[Route("/show/{id}")]
    public function showProduct(Product $product):Response{
        return $this->json($product,200,[],["groups"=>"forOrderSerializing"]);
    }
}
