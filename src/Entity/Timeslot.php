<?php

namespace App\Entity;

use App\Repository\TimeslotRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TimeslotRepository::class)]
class Timeslot
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?float $startDateTime = null;

    /**
     * @var Collection<int, Group>
     */
    #[ORM\ManyToMany(targetEntity: Group::class, mappedBy: 'timeSlots')]
    private Collection $groupss;

    #[ORM\ManyToOne(inversedBy: 'timeSlots')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Stand $stands = null;

    public function __construct()
    {
        $this->groupss = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStartDateTime(): ?float
    {
        return $this->startDateTime;
    }

    public function setStartDateTime(float $startDateTime): static
    {
        $this->startDateTime = $startDateTime;

        return $this;
    }

    /**
     * @return Collection<int, Group>
     */
    public function getGroupss(): Collection
    {
        return $this->groupss;
    }

    public function addGroupss(Group $groupss): static
    {
        if (!$this->groupss->contains($groupss)) {
            $this->groupss->add($groupss);
            $groupss->addTimeSlot($this);
        }

        return $this;
    }

    public function removeGroupss(Group $groupss): static
    {
        if ($this->groupss->removeElement($groupss)) {
            $groupss->removeTimeSlot($this);
        }

        return $this;
    }

    public function getStands(): ?Stand
    {
        return $this->stands;
    }

    public function setStands(?Stand $stands): static
    {
        $this->stands = $stands;

        return $this;
    }
}
