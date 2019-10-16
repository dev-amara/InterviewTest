<?php

namespace App\Managers;


use App\Entity\EntityInterface;

interface ManagerInterface
{
    public function getEntityClassName();
    public function get($id);
    public function getAll();
    public function create(EntityInterface &$data, $isThrowable);
    public function delete($id);
}