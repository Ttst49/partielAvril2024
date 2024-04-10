<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\Product;
use App\Repository\ProductRepository;
use App\Service\CartService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route("api/cart")]
class CartController extends AbstractController
{
    #[Route('/', name: 'app_cart')]
    public function showCart(CartService $service, ProductRepository $repository): Response
    {

        $cart = $service;
        //dd($cart);
        return $this->render('cart/index.html.twig', [
            "cart"=>$cart,
        ]);
    }


    #[Route("/json")]
    public function getCartApi(CartService $service):Response{
        return $this->json($service->getCart(),200,[],["groups"=>"forOrderSerializing"]);
    }


    #[Route("/validate",name: "app_cart_validate")]
    public function validateOrder(ProductRepository $repository,Request $request,CartService $service, EntityManagerInterface $manager):Response{

        $cart = $request->getPayload()->all();
        dd($cart);
        if ($cart){
            $order = new Order();
            $order->setOwner($this->getUser());
            foreach ($cart as $item){
                $product = $repository->findOneBy(["id"=>$item["product"]["id"]]);
                $order->addProduct($product);
            }
            $service->emptyCart();
            $manager->persist($order);
            $manager->flush();
            return $this->json($order,200,[],["groups"=>"forOrderSerializing"]);
        }
        return $this->redirectToRoute("app_cart");
    }

}
