<?php

namespace App\Services;


use App\Entity\EntityInterface;
use Doctrine\ORM\EntityManagerInterface;

abstract class AbstractService implements IService
{
    private $em;
    private $entityClassName;

    public function __construct(
        EntityManagerInterface $em,
        string $entityClassName
    ) {
        $this->em = $em;
        $this->entityClassName = $entityClassName;
    }

    public function get($id)
    {
        return $this
            ->em
            ->getRepository($this->entityClassName)
            ->find($id)
            ;
    }

    public function getAll()
    {
        return $this->em->getRepository($this->entityClassName)->findBy(
            [],
            ['id' => 'DESC']
        );
    }

    public function create(EntityInterface $data)
    {
        $this->em->persist($data);

        $this->em->flush();

        return;
    }

    public function delete($id)
    {
        $data = $this
            ->em
            ->getRepository($this->entityClassName)
            ->find($id)
            ;

        $this->em->remove($data);

        $this->em->flush();

        return;
    }

    public function getEntityClassName()
    {
        return $this->entityClassName;
    }

}