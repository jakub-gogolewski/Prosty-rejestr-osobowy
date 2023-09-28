<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Persons;
use Symfony\Component\HttpFoundation\Request;
use App\Form\PersonsType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Adresses;
use App\Form\AdressType;

class PersonsController extends AbstractController
{   
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/', name: 'homepage')]
    public function index()
    {
        $persons = $this->entityManager->getRepository(Persons::class)->findAll();

        return $this->render('index.html.twig', [
            'persons' => $persons,
        ]);
    }

    #[Route('/persons/add', name: 'persons_add')]
    public function add(Request $request)
    {
        $person = new Persons(); // Tworzymy nowy obiekt Persons

        $form = $this->createForm(PersonsType::class, $person);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($person);
            $this->entityManager->flush();

            $this->addFlash('success', 'Osoba została dodana.');

            return $this->redirectToRoute('persons_list'); // Przekieruj gdzie chcesz po dodaniu osoby
        }

        return $this->render('forms/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
