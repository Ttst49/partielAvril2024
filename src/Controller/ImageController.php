<?php

namespace App\Controller;

use App\Entity\Image;
use App\Entity\Product;
use App\Form\ImageType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ImageController extends AbstractController
{
    #[Route('/image/{id}', name: 'app_image_addToProduct')]
    public function index(Product $product, Request $request, EntityManagerInterface $manager): Response
    {
        $image = new Image();
        $imageForm = $this->createForm(ImageType::class,$image);
        $imageForm->handleRequest($request);
        if ($imageForm->isSubmitted() && $imageForm->isValid()){
            $product->setImage($image);
            $request->attributes->set("image",$image);
            $manager->persist($image);
            $manager->flush();

            return $this->redirectToRoute("app_admin",[

                ]);
        }
        return $this->render('image/index.html.twig', [
            "imageForm"=>$imageForm->createView()
        ]);
    }
}
