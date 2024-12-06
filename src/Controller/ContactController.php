<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{

    #[Route('/contact', name: 'app_contact')]
    public function index(EntityManagerInterface $entityManager, Request $request): Response
    {
        $contact = new Contact();
        $contact_form = $this->createForm(ContactType::class, $contact);

        $contact_form->handleRequest($request);

        if ($contact_form->isSubmitted() && $contact_form->isValid()) {

            $entityManager->persist($contact);
            $entityManager->flush();

            $this->addFlash('success', 'Votre message a bien été envoyé.');

            return $this->redirectToRoute('contact_send', ['id' => $contact->getId()]);
        }

        return $this->render('contact/index.html.twig', [
            'formView' => $contact_form->createView(),
        ]);
    }



    #[Route('/contact_send/{id}', name: 'contact_send')]
    public function contactSend(int $id, EntityManagerInterface $entityManager): Response
    {
        $contact = $entityManager->getRepository(Contact::class)->find($id);


        return $this->render('contact/contact_send.html.twig', [
            'contact' => $contact,
        ]);
    }


}

