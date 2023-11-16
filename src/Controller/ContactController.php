<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Repository\ContactRepository;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    #[Route('/contact')]
    public function index(ContactRepository $contactRepository, Request $request): Response
    {
        $search = $request->query->get('search', '');
        $contacts = $contactRepository->search($search);

        return $this->render('contact/index.html.twig', ['contacts' => $contacts, 'search' => $search]);
    }

    #[Route('/contact/{id}')]
    public function show(
        #[MapEntity(expr: 'repository.findWithCategory(id)')]
        ?Contact $contact
    ): Response {
        if (null === $contact) {
            throw $this->createNotFoundException("le contact n'existe pas ");
        }

        return $this->render('contact/show.html.twig', ['contact' => $contact]);
    }
}
