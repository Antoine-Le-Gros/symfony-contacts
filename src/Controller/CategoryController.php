<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use App\Repository\ContactRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    #[Route('/category')]
    public function index(CategoryRepository $categoryRepository): Response
    {
        $categories = $categoryRepository->findBy([], ['name' => 'ASC']);

        return $this->render('category/index.html.twig', ['categories' => $categories]);
    }
    #[Route('/category/{id}')]
    public function show(?Category $category): Response
    {
        $contactRepository = new ContactRepository();
        if (empty($category)) {
            throw $this->createNotFoundException("la catégorie n'existe pas ");
        }
        $contacts = $contactRepository->search($search);
        return $this->render('contact/_contacts.html.twig', ['contacts' => $contacts])
    }
}
