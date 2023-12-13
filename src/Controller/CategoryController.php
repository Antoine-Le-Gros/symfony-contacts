<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('IS_AUTHENTICATED_REMEMBERED')]
class CategoryController extends AbstractController
{
    #[Route('/category')]
    public function index(CategoryRepository $categoryRepository): Response
    {
        return $this->render('category/index.html.twig', ['categories' => $categoryRepository->findAllAlphabeticallyWithContactCount()]);
    }

    #[Route('/category/{id}')]
    public function show(?Category $category): Response
    {
        if (empty($category)) {
            throw $this->createNotFoundException("la catégorie n'existe pas ");
        }

        return $this->render('category/show.html.twig', ['category' => $category]);
    }
}
