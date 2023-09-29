<?php

namespace App\Entity;

use App\Repository\AdressesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AdressesRepository::class)]
class Adresses
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 6)]
    private ?string $postal = null;

    #[ORM\Column(length: 255)]
    private ?string $city = null;

    #[ORM\Column(length: 255)]
    private ?string $street = null;

    #[ORM\Column(length: 50)]
    private ?string $street_number = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $flat_number = null;

    #[ORM\ManyToOne(inversedBy: 'Adresses')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Persons $persons_key = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPostal(): ?string
    {
        return $this->postal;
    }

    public function setPostal(string $postal): static
    {
        $this->postal = $postal;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): static
    {
        $this->city = $city;

        return $this;
    }

    public function getStreet(): ?string
    {
        return $this->street;
    }

    public function setStreet(string $street): static
    {
        $this->street = $street;

        return $this;
    }

    public function getStreetNumber(): ?string
    {
        return $this->street_number;
    }

    public function setStreetNumber(string $street_number): static
    {
        $this->street_number = $street_number;

        return $this;
    }

    public function getFlatNumber(): ?string
    {
        return $this->flat_number;
    }

    public function setFlatNumber(?string $flat_number): static
    {
        $this->flat_number = $flat_number;

        return $this;
    }

    public function getPersonsKey(): ?Persons
    {
        return $this->persons_key;
    }

    public function setPersonsKey(?Persons $persons_key): static
    {
        $this->persons_key = $persons_key;

        return $this;
    }
}
