<?php

namespace App\Entity;

use App\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\AccountRepository;

/**
 * @ORM\Entity(repositoryClass=AccountRepository::class)
 */
class Account
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $accountNumber;

    /**
     * @ORM\Column(type="float")
     */
    private $balance;

    /**
     * @ORM\ManyToOne(targetEntity=user::class, inversedBy="accounts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $owner;

    /**
     * @ORM\OneToMany(targetEntity=Trading::class, mappedBy="sourceAccount")
     */
    private $tradings;

    public function __toString()
    {
        return $this->accountNumber;
    }


    public function __construct()
    {
        $this->tradings = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAccountNumber(): ?string
    {
        return $this->accountNumber;
    }

    public function setAccountNumber(string $accountNumber): self
    {
        $this->accountNumber = $accountNumber;

        return $this;
    }

    public function getBalance(): ?float
    {
        return $this->balance;
    }

    public function setBalance(float $balance): self
    {
        $this->balance = $balance;

        return $this;
    }

    public function getOwner(): ?User
    {
        return $this->owner;
    }

    public function setOwner(?User $owner): self
    {
        $this->owner = $owner;

        return $this;
    }

    /**
     * @return Collection<int, Trading>
     */
    public function getTradings(): Collection
    {
        return $this->tradings;
    }

    public function addTrading(Trading $trading): self
    {
        if (!$this->tradings->contains($trading)) {
            $this->tradings[] = $trading;
            $trading->setSourceAccount($this);
        }

        return $this;
    }

    public function removeTrading(Trading $trading): self
    {
        if ($this->tradings->removeElement($trading)) {
            // set the owning side to null (unless already changed)
            if ($trading->getSourceAccount() === $this) {
                $trading->setSourceAccount(null);
            }
        }

        return $this;
    }
}
