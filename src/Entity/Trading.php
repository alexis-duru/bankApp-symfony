<?php

namespace App\Entity;

use App\Repository\TradingRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TradingRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class Trading
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float")
     */
    private $amount;

    /**
     * @ORM\ManyToOne(targetEntity=Account::class, inversedBy="tradings")
     */
    private $sourceAccount;

    /**
     * @ORM\ManyToOne(targetEntity=Account::class, inversedBy="tradings")
     */
    private $destinationAccount;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

     /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $createdAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getSourceAccount(): ?Account
    {
        return $this->sourceAccount;
    }

    public function setSourceAccount(?Account $sourceAccount): self
    {
        $this->sourceAccount = $sourceAccount;

        return $this;
    }

    public function getDestinationAccount(): ?Account
    {
        return $this->destinationAccount;
    }

    public function setDestinationAccount(?Account $destinationAccount): self
    {
        $this->destinationAccount = $destinationAccount;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable('now');
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    /**
     * @ORM\PrePersist()
     */
    public function setCreatedAt(): void
    {
        $this->createdAt = new \DateTimeImmutable('now');
    }

        public function getFormattedCreatedAt(): string
    {
        return $this->createdAt->format('d-m-Y');
    }
}
