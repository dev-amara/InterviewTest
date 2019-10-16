<?php

namespace App\Controller;


use App\Managers\ManagerInterface;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use FOS\RestBundle\Controller\Annotations as Rest;


abstract class AbstractController extends \App\Helpers\Utils\AbstractController implements ControllerInterface
{
    /**
     * @var ManagerInterface
     */
    private $manager;

    public function __construct(
        SerializerInterface $serializer,
        ValidatorInterface $validator,
        RequestStack $requestStack,
        ManagerInterface $manager
    ) {
        parent::__construct(
            $serializer,
            $validator,
            $requestStack
        );

        $this->manager = $manager;
    }

    /**
     * @Rest\Get("/{id}")
     * @param $id
     * @return Response
     */
    public function _get($id)
    {
        $context = SerializationContext::create()
            ->setGroups(['list']);

        $entity = $this
            ->manager
            ->get($id)
        ;

        return $this->view(
            $entity,
            Response::HTTP_OK,
            $context
        );
    }

    /**
     * @Rest\Get("")
     * @return Response
     */
    public function _getAll()
    {
        $context = SerializationContext::create()
            ->setGroups(['list']);

        $data = $this->manager->getAll();

        return $this->view(
            $data,
            Response::HTTP_OK,
            $context
        );
    }

    /**
     * @Rest\Post("")
     * @return Response
     */
    public function _post()
    {
        $context = SerializationContext::create()
            ->setGroups(['list']);

        $group = 'register';

        $this->validateContentType(
            $this->request
                ->headers
                ->get('content_type')
        );

        $this->validateRequestData(
            $this->request->getContent(),
            $this->manager->getEntityClassName(),
            $group
        );

        $this
            ->manager
            ->create(
                $this->data,
                true
            );

        return $this->view(
            $this->data,
            Response::HTTP_CREATED,
            $context
        );
    }

    /**
     * @Rest\Delete("/{id}")
     * @param $id
     * @return Response
     */
    public function _del($id)
    {
        $context = SerializationContext::create()
            ->setGroups(['list']);

        $this->manager->delete($id);

        return $this->view(
            null,
            Response::HTTP_OK,
            $context
        );
    }

}