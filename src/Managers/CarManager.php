<?php

namespace App\Managers;


use App\Services\CarService;

class CarManager extends AbstractManager
{
    public function __construct(CarService $service)
    {
        parent::__construct($service);
    }
}