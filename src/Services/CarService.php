<?php

namespace App\Services;


use App\Entity\Car;
use Doctrine\ORM\EntityManagerInterface;

class CarService extends AbstractService
{
    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct($em, Car::class);
    }
}