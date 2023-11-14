<?php

namespace App\Entity;

use App\Repository\InventoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InventoryRepository::class)]
class Inventory
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'inventory', targetEntity: Cap::class, orphanRemoval: true)]
    private Collection $caps;

    #[ORM\ManyToOne(inversedBy: 'inventory')]
    private ?Member $member = null;

    public function __construct()
    {
        $this->caps = new ArrayCollection();
    }

    public function __toString() {
        return $this->name;
    }
    
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
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

    /**
     * @return Collection<int, Cap>
     */
    public function getCaps(): Collection
    {
        return $this->caps;
    }

    public function addCap(Cap $cap): static
    {
        if (!$this->caps->contains($cap)) {
            $this->caps->add($cap);
            $cap->setInventory($this);
        }

        return $this;
    }

    public function removeCap(Cap $cap): static
    {
        if ($this->caps->removeElement($cap)) {
            // set the owning side to null (unless already changed)
            if ($cap->getInventory() === $this) {
                $cap->setInventory(null);
            }
        }

        return $this;
    }

    public function getMember(): ?Member
    {
        return $this->member;
    }

    public function setMember(?Member $member): static
    {
        $this->member = $member;

        return $this;
    }
}
