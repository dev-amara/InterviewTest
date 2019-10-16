<?php

namespace App\Managers;


use App\Entity\EntityInterface;
use App\Services\IService;

abstract class AbstractManager implements ManagerInterface
{
    private $service;

    public function __construct(IService $service)
    {
        $this->service = $service;
    }

    public function getEntityClassName()
    {
        return $this->service->getEntityClassName();
    }

    public function get($id)
    {
        return $this
            ->service
            ->get($id)
            ;
    }

    public function getAll()
    {
        return $this
            ->service
            ->getAll()
            ;
    }

    public function create(EntityInterface &$data, $isThrowable)
    {
        $this
            ->service
            ->create($data)
        ;

        return;
    }

    public function delete($id)
    {
        $this->service->delete($id);

        return;
    }

}