<?php

namespace App\Controller;

use App\Repository\ContactRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    #[Route('/contact')]
    public function index(ContactRepository $contactRepository): Response
    {
        $contacts = $contactRepository->findBy([], ['lastname' => 'ASC', 'firstname' => 'ASC']);

        return $this->render('contact/index.html.twig', ['contacts' => $contacts]);
    }

    #[Route('/contact/{contactId}')]
    public function show(int $contactId, ContactRepository $contactRepository): Response
    {
        $contact = $contactRepository->findOneBy(['id' => $contactId]);
        if (empty($contact)){
            throw new NotFoundHttpException("le contact numéro $contactId n'existe pas ");
        }
        return $this->render('contact/show.html.twig', ['contact' => $contact]);
    }
}
