<?php

namespace App\Controller;

use App\Managers\CarManager;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use FOS\RestBundle\Controller\Annotations as Rest;

/**
 * Class UserController
 * @package App\Controller
 * @Rest\Route("api/v1/cars")
 */
class CarController extends AbstractController
{
    public function __construct(
        SerializerInterface $serializer,
        ValidatorInterface $validator,
        RequestStack $requestStack,
        CarManager $manager
    ) {
        parent::__construct(
            $serializer,
            $validator,
            $requestStack,
            $manager
        );
    }
}
