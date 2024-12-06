<?php

namespace App\Entity;

use App\Repository\RoomRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RoomRepository::class)]
class Room
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Establishment::class, inversedBy: 'rooms')]
    private ?Establishment $establishment = null;

    #[ORM\OneToMany(mappedBy: 'room', targetEntity: Event::class)]
    private Collection $events;

    #[ORM\OneToMany(mappedBy: 'room', targetEntity: Image::class)]
    private Collection $images;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?int $capacity = null;

    #[ORM\Column]
    private ?int $establishment_id = null;

    public function getImages(): Collection
    {
        return $this->images;
    }

    public function setImages(Collection $images): static
    {
        $this->images = $images;
        return $this;
    }

    public function addImage(Image $image): static
    {
        $this->images->add($image);

        return $this;
    }
    public function getEvents(): Collection {
        return $this->events;
    }

    public function setEvents(Collection $events): self {
        $this->events = $events;
        return $this;
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

    public function getCapacity(): ?int
    {
        return $this->capacity;
    }

    public function setCapacity(int $capacity): static
    {
        $this->capacity = $capacity;

        return $this;
    }

    public function getEstablishment(): ?Establishment
    {
        return $this->establishment;
    }

    public function setEstablishment(?Establishment $establishment): self
    {
        $this->establishment = $establishment;

        return $this;
    }
}
