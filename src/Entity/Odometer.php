<?php

namespace App\Entity;

use App\Repository\OdometerRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OdometerRepository::class)
 */
class Odometer
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Car::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $car;

    /**
     * @ORM\Column(type="integer", options={"unsigned"=true})
     */
    private $value;

    /**
     * @ORM\Column(type="decimal", precision=5, scale=2, nullable=true, options={"unsigned"=true})
     */
    private $fuel;

    /**
     * @ORM\Column(type="decimal", precision=11, scale=2, nullable=true, options={"unsigned"=true})
     */
    private $price;
    private $traveled;
    private $consumption;

    /**
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @ORM\Column(type="boolean", options={"default"=true})
     */
    private $active;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCar(): ?Car
    {
        return $this->car;
    }

    public function setCar(?Car $car): self
    {
        $this->car = $car;

        return $this;
    }

    public function getValue(): ?int
    {
        return $this->value;
    }

    public function setValue(?int $value): self
    {
        $this->value = $value;

        return $this;
    }

    public function getFuel(): ?string
    {
        return $this->fuel;
    }

    public function setFuel(?string $fuel): self
    {
        $this->fuel = $fuel;

        return $this;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(?string $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(?\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function calculatePaid(): float
    {
        return $this->fuel * $this->price;
    }

    public function getTraveled(): ?int
    {
        return $this->traveled;
    }

    public function setTraveled(int $traveled): self
    {
        $this->traveled = $traveled;

        return $this;
    }

    public function getConsumption(): ?float
    {
        return $this->consumption;
    }

    public function setConsumption(?float $consumption): self
    {
        $this->consumption = $consumption;

        return $this;
    }

    public function isActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): self
    {
        $this->active = $active;

        return $this;
    }
}
