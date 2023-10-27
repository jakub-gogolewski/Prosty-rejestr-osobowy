<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Persons;
use Symfony\Component\HttpFoundation\Request;
use App\Form\PersonsType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Adresses;
use App\Form\AdressType;
use App\Form\SearchType;

class PersonsController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    
    #[Route('/', name: 'homepage')]
    public function index(Request $request)
    {
        $form = $this->createForm(SearchType::class);

        $form->handleRequest($request);

        $searchTerm = $form->get('search')->getData();

        $persons = $this->entityManager->getRepository(Persons::class)->searchPersonsAndAddresses($searchTerm);

        if ($searchTerm) {
            $this->addFlash('success', 'Wyświetlam wyniki zawierające frazę "' . $searchTerm . '"');
        }

        return $this->render('index.html.twig', [
            'persons' => $persons,
            'form' => $form->createView(), 
        ]);
    }

    #[Route('/persons/add', name: 'persons_add')]
    public function add(Request $request)
    {
        $person = new Persons();
        $form = $this->createForm(PersonsType::class, $person);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($person);
            $this->entityManager->flush();
    
            if ($request->get('add_address_decision_made', false)) {
                if ($request->get('add_address', false)) {
                    return $this->redirectToRoute('add_address', ['id' => $person->getId()]);
                } else {
                    $this->addFlash('success', 'Osoba została dodana.');
                    return $this->redirectToRoute('homepage');
                }
            }
        }
    
        return $this->render('forms/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/add-address/{id}', name: 'add_address')]
    public function addAddress(Request $request, int $id)
    {
        $person = $this->entityManager->getRepository(Persons::class)->find($id);

        if (!$person) {
            throw $this->createNotFoundException('Osoba o podanym ID nie istnieje.');
        }

        $adress = new Adresses();

        // Automatycznie przypisz osobę na podstawie kontekstu
        $adress->setPersonsKey($person);

        $form = $this->createForm(AdressType::class, $adress);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($adress);
            $this->entityManager->flush();

            $this->addFlash('success', 'Adres został dodany.');

            return $this->redirectToRoute('homepage'); // Przekieruj na stronę główną
        }

        return $this->render('forms/add_address.html.twig', [
            'form' => $form->createView(),
            'person' => $person,
        ]);
    }

    #[Route('/edit-person/{id}', name: 'edit_person')]
public function editPerson(Request $request, int $id)
{
    $person = $this->entityManager->getRepository(Persons::class)->find($id);

    if (!$person) {
        throw $this->createNotFoundException('Osoba o podanym ID nie istnieje.');
    }

    $form = $this->createForm(PersonsType::class, $person);

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $this->entityManager->flush();

        $this->addFlash('success', 'Osoba została zaktualizowana.');

        return $this->redirectToRoute('homepage'); // Przekieruj na stronę główną
    }

    return $this->render('forms/edit.html.twig', [
        'form' => $form->createView(),
        'person' => $person,
    ]);
}

#[Route('/delete-person/{id}', name: 'delete_person')]
public function deletePerson(Request $request, int $id)
{
    $person = $this->entityManager->getRepository(Persons::class)->find($id);

    if (!$person) {
        throw $this->createNotFoundException('Osoba o podanym ID nie istnieje.');
    }

    $this->entityManager->remove($person);
    $this->entityManager->flush();

    $this->addFlash('success', 'Osoba została usunięta.');

    return $this->redirectToRoute('homepage');
}

#[Route('/edit-address/{personId}/{addressId}', name: 'edit_address')]
public function edit(Request $request, int $personId, int $addressId)
{
    $person = $this->entityManager->getRepository(Persons::class)->find($personId);

    if (!$person) {
        throw $this->createNotFoundException('Osoba o podanym ID nie istnieje.');
    }

    $address = $this->entityManager->getRepository(Adresses::class)->find($addressId);

    if (!$address || $address->getPersonsKey() !== $person) {
        throw $this->createNotFoundException('Adres o podanym ID nie istnieje lub nie należy do wybranej osoby.');
    }

    $form = $this->createForm(AdressType::class, $address);

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $this->entityManager->flush();

        $this->addFlash('success', 'Adres został zaktualizowany.');

        return $this->redirectToRoute('homepage');
    }

    return $this->render('forms/edit_address.html.twig', [
        'form' => $form->createView(),
        'person' => $person,
        'address' => $address,
    ]);
}

#[Route('/delete-address/{addressId}', name: 'delete_address')]
public function deleteAddress(int $addressId, EntityManagerInterface $entityManager): Response
    {
        $address = $entityManager->getRepository(Adresses::class)->find($addressId);

        if (!$address) {
            throw $this->createNotFoundException('Nie znaleziono adresu o danym ID');
        }

        $entityManager->remove($address);
        $entityManager->flush();

        $this->addFlash('success', 'Adres został usunięty pomyślnie!');

        return $this->redirectToRoute('homepage'); //Przekieruj na stronę główną
    }

}
