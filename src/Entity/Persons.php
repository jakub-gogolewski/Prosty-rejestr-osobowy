<?php

namespace App\Entity;

use App\Repository\PersonsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PersonsRepository::class)]
class Persons
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $name = null;

    #[ORM\Column(length: 150)]
    private ?string $surname = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $age = null;

    #[ORM\Column(length: 50)]
    private ?string $sex = null;

    #[ORM\OneToMany(mappedBy: 'persons_key', targetEntity: Adresses::class)]
    private Collection $Adress;

    public function __construct()
    {
        $this->Adress = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getSurname(): ?string
    {
        return $this->surname;
    }

    public function setSurname(string $surname): static
    {
        $this->surname = $surname;

        return $this;
    }

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(int $age): static
    {
        $this->age = $age;

        return $this;
    }

    public function getSex(): ?string
    {
        return $this->sex;
    }

    public function setSex(string $sex): static
    {
        $this->sex = $sex;

        return $this;
    }

    /**
     * @return Collection<int, Adresses>
     */
    public function getAdress(): Collection
    {
        return $this->Adress;
    }

    public function addAdress(Adresses $adress): static
    {
        if (!$this->Adress->contains($adress)) {
            $this->Adress->add($adress);
            $adress->setPersonsKey($this);
        }

        return $this;
    }

    public function removeAdress(Adresses $adress): static
    {
        if ($this->Adress->removeElement($adress)) {
            // set the owning side to null (unless already changed)
            if ($adress->getPersonsKey() === $this) {
                $adress->setPersonsKey(null);
            }
        }

        return $this;
    }
}
