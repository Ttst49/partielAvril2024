<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route("/admin")]
class AdminController extends AbstractController
{
    #[Route('/', name: 'app_admin')]
    public function index(ProductRepository $repository): Response
    {
        return $this->render('admin/index.html.twig', [
            'products' => $repository->findAll(),
        ]);
    }


    #[Route("/new",name: "app_admin_create")]
    public function createProduct(EntityManagerInterface $manager, Request $request):Response{


        $product = new Product();
        $productForm = $this->createForm(ProductType::class,$product);
        $productForm->handleRequest($request);
        if ($productForm->isSubmitted() && $productForm->isValid()){

            $manager->persist($product);
            $manager->flush();
            return $this->redirectToRoute("app_admin");
        }

        return $this->render("admin/new.html.twig",[
            "image"=>null,
            "productForm"=>$productForm->createView()
        ]);
    }
}
