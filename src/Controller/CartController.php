<?php

namespace App\Controller;

use App\Entity\Order;
use App\Repository\ProductRepository;
use App\Service\CartService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route("/cart")]
class CartController extends AbstractController
{
    #[Route('/', name: 'app_cart')]
    public function showCart(CartService $service,ProductRepository $repository): Response
    {
        $service->addProduct($repository->find(1),1);
        $cart = $service;
        //dd($cart);
        return $this->render('cart/index.html.twig', [
            "cart"=>$cart,
        ]);
    }


    #[Route("/validate",name: "app_cart_validate")]
    public function validateOrder(CartService $service, EntityManagerInterface $manager):Response{

        $cart = $service->getCart();
        if ($cart){
            $order = new Order();
            $order->setOwner($this->getUser());
            foreach ($cart as $item){
                $order->addProduct($item["product"]);
            }
            $service->emptyCart();
            $manager->persist($order);
            $manager->flush();
            return $this->json($order,200,[],["groups"=>"forOrderSerializing"]);
        }
        return $this->redirectToRoute("app_cart");
    }

}
