<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Annotations\Constraint as Asset;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CarRepository")
 */
class Car implements EntityInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Serializer\Groups({"list"})
     */
    private $id;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     * @Serializer\Groups({"list"})
     */
    private $isAllocated = false;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Serializer\Groups({"list"})
     * @Assert\
     */
    private $parkingPlaceNb;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Serializer\Groups({"list"})
     */
    private $carType;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *  @Serializer\Groups({"list"})
     */
    private $registration;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *  @Serializer\Groups({"list"})
     */
    private $type;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *  @Serializer\Groups({"list"})
     */
    private $model;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Serializer\Groups({"list"})
     */
    private $power;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Serializer\Groups({"list"})
     */
    private $brand;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIsAllocated(): ?bool
    {
        return $this->isAllocated;
    }

    public function setIsAllocated(bool $isAllocated): self
    {
        $this->isAllocated = $isAllocated;

        return $this;
    }

    public function getParkingPlaceNb(): ?int
    {
        return $this->parkingPlaceNb;
    }

    public function setParkingPlaceNb(int $parkingPlaceNb): self
    {
        $this->parkingPlaceNb = $parkingPlaceNb;

        return $this;
    }

    public function getCarType(): ?string
    {
        return $this->carType;
    }

    public function setCarType(string $carType): self
    {
        $this->carType = $carType;

        return $this;
    }

    public function getRegistration(): ?string
    {
        return $this->registration;
    }

    public function setRegistration(string $registration): self
    {
        $this->registration = $registration;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getModel(): ?string
    {
        return $this->model;
    }

    public function setModel(string $model): self
    {
        $this->model = $model;

        return $this;
    }

    public function getPower(): ?string
    {
        return $this->power;
    }

    public function setPower(string $power): self
    {
        $this->power = $power;

        return $this;
    }

    public function getBrand(): ?string
    {
        return $this->brand;
    }

    public function setBrand(string $brand): self
    {
        $this->brand = $brand;

        return $this;
    }
}
