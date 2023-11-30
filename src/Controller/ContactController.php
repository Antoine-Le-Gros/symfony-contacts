<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use App\Repository\ContactRepository;
use Doctrine\ORM\EntityManagerInterface;
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

    #[Route('/contact/{id}', requirements: ['id' => '\d+'])]
    public function show(
        #[MapEntity(expr: 'repository.findWithCategory(id)')]
        ?Contact $contact
    ): Response {
        if (null === $contact) {
            throw $this->createNotFoundException("le contact n'existe pas ");
        }

        return $this->render('contact/show.html.twig', ['contact' => $contact]);
    }

    #[Route('/contact/{id}/update', requirements: ['id' => '\d+'])]
    public function update(Contact $contact,
        Request $request,
        EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ContactType::class, $contact);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $contact = $form->getData();
            $entityManager->flush();

            return $this->redirectToRoute('app_contact_show', [
                'id' => $contact->getId(),
            ]);
        }

        return $this->render('contact/update.html.twig', [
            'contact' => $contact,
            'form' => $form,
        ]);
    }

    #[Route('/contact/create')]
    public function create(): Response
    {
        $form = $this->createForm(ContactType::class);

        return $this->render('contact/create.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/contact/{id}/delete', requirements: ['id' => '\d+'])]
    public function delete(Contact $contact): Response
    {
        $form = $this->createForm(ContactType::class, $contact);

        return $this->render('contact/delete.html.twig', [
            'contact' => $contact,
            'form' => $form,
        ]);
    }
}
