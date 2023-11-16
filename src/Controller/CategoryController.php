<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    #[Route('/category')]
    public function index(CategoryRepository $categoryRepository): Response
    {
        $categories = $categoryRepository->createQueryBuilder('c')
            ->leftJoin('c.contacts', 'contacts')
            ->groupBy('c')
            ->select('c as category')
            ->addSelect('COUNT(contacts) as count')
            ->orderBy('c.name', 'ASC')
            ->getQuery()
            ->execute();
        dump($categories);

        return $this->render('category/index.html.twig', ['categories' => $categories]);
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
