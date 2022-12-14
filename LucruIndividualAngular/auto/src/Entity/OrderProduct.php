<?php

namespace App\Entity;

use App\Repository\OrderProductRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderProductRepository::class)]
class OrderProduct
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Product $product = null;

    #[ORM\ManyToOne(inversedBy: 'orderProducts')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Order $ord = null;

    #[ORM\Column]
    private ?int $count = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): self
    {
        $this->product = $product;

        return $this;
    }

    public function getOrd(): ?Order
    {
        return $this->ord;
    }

    public function setOrd(?Order $ord): self
    {
        $this->ord = $ord;

        return $this;
    }

    public function getCount(): ?int
    {
        return $this->count;
    }

    public function setCount(int $count): self
    {
        $this->count = $count;

        return $this;
    }

    public function addCount(int $count): self
    {
        $this->count += $count;

        return $this;
    }

    public function __toString(): string
    {
        return $this->getProduct()->getName() . ' ' . $this->getOrd()->getId();
    }
}
