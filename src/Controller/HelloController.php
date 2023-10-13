<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HelloController extends AbstractController
{
    #[Route('/hello', name: 'app_hello')]
    public function index(): Response
    {
        return $this->render('hello/index.html.twig', [
            'controller_name' => 'HelloController',
        ]);
    }

    #[Route('/hello/{slug}')]
    public function world(string $slug): Response
    {
        return $this->render('hello/world.html.twig', ['slug' => $slug]);
    }

    #[Route('/hello/{name}/{times}')]
    public function manyTimes(string $name, int $times): Response
    {
        return $this->render('hello/many_times.html.twig', ['name' => $name, 'times' => $times]);
    }
}
