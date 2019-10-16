<?php

namespace App\Services;


use App\Entity\EntityInterface;

interface IService
{
    public function getEntityClassName();
    public function get($id);
    public function getAll();

    /**
     * @param EntityInterface $data
     * @return EntityInterface
     */
    public function create(EntityInterface $data);
    public function delete($id);
}