<?php

namespace App\Entity;

use App\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\AccountRepository;

/**
 * @ORM\Entity(repositoryClass=AccountRepository::class)
 * @ORM\HasLifecycleCallbacks()
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

      /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\OneToMany(targetEntity=Recharge::class, mappedBy="account")
     */
    private $recharges;

    // ...

    /**
     * @ORM\PrePersist
     */
    public function setCreatedAtValue()
    {
        $this->created_at = new \DateTime();
    }

    public function __toString()
    {
        return $this->accountNumber;
    }


    public function __construct()
    {
        $this->tradings = new ArrayCollection();
        $this->recharges = new ArrayCollection();
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

    /**
     * @ORM\PrePersist
     */
    public function setAccountNumberValue()
    {
        $this->accountNumber = str_pad(random_int(0, 99999999), 8, '0', STR_PAD_LEFT);
    }

    /**
     * @return Collection<int, Recharge>
     */
    public function getRecharges(): Collection
    {
        return $this->recharges;
    }

    public function addRecharge(Recharge $recharge): self
    {
        if (!$this->recharges->contains($recharge)) {
            $this->recharges[] = $recharge;
            $recharge->setAccount($this);
        }

        return $this;
    }

    public function removeRecharge(Recharge $recharge): self
    {
        if ($this->recharges->removeElement($recharge)) {
            // set the owning side to null (unless already changed)
            if ($recharge->getAccount() === $this) {
                $recharge->setAccount(null);
            }
        }

        return $this;
    }

    public function updateBalance(float $amount)
    {
        $this->balance += $amount;
    }

}
