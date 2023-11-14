<?php

namespace App\Entity;

use App\Repository\MemberRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MemberRepository::class)]
class Member
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'member', targetEntity: Inventory::class, orphanRemoval: true)]
    private Collection $inventory;

    #[ORM\OneToOne(mappedBy: 'member', cascade: ['persist', 'remove'])]
    private ?User $user = null;

    #[ORM\OneToMany(mappedBy: 'member', targetEntity: Wardrobe::class, orphanRemoval: true)]
    private Collection $wardrobes;

    public function __construct()
    {
        $this->inventory = new ArrayCollection();
        $this->wardrobes = new ArrayCollection();
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

    /**
     * @return Collection<int, Inventory>
     */
    public function getInventory(): Collection
    {
        return $this->inventory;
    }

    public function addInventory(Inventory $inventory): static
    {
        if (!$this->inventory->contains($inventory)) {
            $this->inventory->add($inventory);
            $inventory->setMember($this);
        }

        return $this;
    }

    public function removeInventory(Inventory $inventory): static
    {
        if ($this->inventory->removeElement($inventory)) {
            // set the owning side to null (unless already changed)
            if ($inventory->getMember() === $this) {
                $inventory->setMember(null);
            }
        }

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        // unset the owning side of the relation if necessary
        if ($user === null && $this->user !== null) {
            $this->user->setMember(null);
        }

        // set the owning side of the relation if necessary
        if ($user !== null && $user->getMember() !== $this) {
            $user->setMember($this);
        }

        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection<int, Wardrobe>
     */
    public function getWardrobes(): Collection
    {
        return $this->wardrobes;
    }

    public function addWardrobe(Wardrobe $wardrobe): static
    {
        if (!$this->wardrobes->contains($wardrobe)) {
            $this->wardrobes->add($wardrobe);
            $wardrobe->setMember($this);
        }

        return $this;
    }

    public function removeWardrobe(Wardrobe $wardrobe): static
    {
        if ($this->wardrobes->removeElement($wardrobe)) {
            // set the owning side to null (unless already changed)
            if ($wardrobe->getMember() === $this) {
                $wardrobe->setMember(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->name ?? ''; 
    }
}
