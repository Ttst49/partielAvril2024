<?php

namespace App\Service;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\RequestStack;

class CartService
{

    private $productRepo;
    private $session;


    public function __construct(ProductRepository $repository, RequestStack $requestStack){

        $this->productRepo = $repository;
        $this->session = $requestStack->getSession();

    }


    public function getCart(): array
    {

        $cart = $this->session->get("sessionCart",[]);

        $entityCart = [];

        foreach ($cart as $productId=> $quantity){

            $items = [
                "product"=>$this->productRepo->find($productId),
                "quantity"=>$quantity
            ];

            $entityCart[]=$items;

        }

        return $entityCart;
    }


    public function addProduct(Product $product, $quantity){
        $cart = $this->session->get("sessionCart",[]);

        if (isset($cart[$product->getId()])){
            $cart[$product->getId()] = $cart[$product->getId()] + $quantity;
        }else{
            $cart[$product->getId()] = $quantity;
        }

        $this->session->set("sessionCart",$cart);

    }


    public function getTotal(){

        $total = 0;

        foreach ($this->getCart() as $item){
            $total += $item["product"]->getPrice() * $item["quantity"];
        }

        return $total;

    }



    public function removeProductRow(Product $product){
        $cart = $this->session->get("sessionCart",[]);
        $productId = $product->getId();

        if (isset($cart[$productId])){
            unset($cart[$productId]);
        }
        $this->session->set("sessionCart",$cart);
    }


    public function removeProduct(Product $product){
        $cart = $this->session->get("sessionCart",[]);
        $productId = $product->getId();

        if (isset($cart[$productId])){
            $cart[$productId]--;

            if ($cart[$productId]===0){
                unset($cart[$productId]);
            }
        }

        $this->session->set("sessionCart",$cart);
    }


    public function emptyCart(){
        $this->session->remove("sessionCart");
    }


    public function countItems(){
        $count = 0;
        $cart = $this->session->get("sessionCart",[]);

        foreach ($cart as $productId=> $quantity) {

            $count += $quantity;
        }
        return $count;
    }


}