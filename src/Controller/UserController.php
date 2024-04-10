<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route("/api/user")]
class UserController extends AbstractController
{
    #[Route('/getActual', name: 'app_user_getActual')]
    public function index(): Response
    {
        return $this->json($this->getUser(),200,[],["groups"=>"forUserIndexing"]);
    }
}
