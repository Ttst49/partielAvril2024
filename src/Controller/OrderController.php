<?php

namespace App\Controller;

use App\Entity\Order;
use App\Repository\OrderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route("/order")]
class OrderController extends AbstractController
{
    #[Route('/', name: 'app_order')]
    public function index(OrderRepository $repository): Response
    {
        return $this->json($repository->findAll(),200,[],["groups"=>"forOrderSerializing"]);
    }

    #[Route("/show/{id}",name: "app_order_show")]
    public function showOrder(Order $order):Response{
        return $this->render("order/index.html.twig",[
            "order"=>$order
        ]);
    }
}
