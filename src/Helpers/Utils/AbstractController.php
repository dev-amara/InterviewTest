<?php

namespace App\Helpers\Utils;

use App\Helpers\Exceptions\ValidationException;
use Doctrine\Common\Inflector\Inflector;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

abstract class AbstractController extends \Symfony\Bundle\FrameworkBundle\Controller\AbstractController
{
    /**
     * The default content type
     *
     * @var string
     */
    public const CONTENT_TYPE = 'application/json';

    /**
     * The default response type
     *
     * @var string
     */
    public const RESPONSE_FORMAT = 'json';

    /**
     * The request data
     *
     * @var mixed
     */
    public $data;

    /**
     * @var RequestStack
     */
    public $request;

    private $serializer;

    private $validator;

    public function __construct(
        SerializerInterface $serializer,
        ValidatorInterface $validator,
        RequestStack $requestStack
    ) {
        $this->serializer = $serializer;
        $this->validator = $validator;
        $this->request = $requestStack->getCurrentRequest();
    }

    /**
     * Validate request content type
     *
     * @param string $contentType
     * @return void
     */
    protected function validateContentType(string $contentType): void
    {
        if (self::CONTENT_TYPE !== $contentType) {
            throw new ValidationException(
                'Invalid content type header.',
                Response::HTTP_UNSUPPORTED_MEDIA_TYPE
            );
        }
    }

    /**
     * Validate Request data
     *
     * @param string $data
     * @param string $model
     * @param string|null $groups
     * @return void
     */
    protected function validateRequestData(string $data, string $model, $groups = null)
    {
        $this->data = $this->serializer->deserialize($data, $model, self::RESPONSE_FORMAT);

        $errors = $this->validator->validate($this->data, null, $groups);

        if ($errors->count() > 0) {
            throw new ValidationException(
                $this->createErrorMessage($errors),
                Response::HTTP_BAD_REQUEST
            );
        }
    }

    /**
     * Generate the Response
     *
     * @param mixed $content
     * @param integer $status
     * @param mixed $context
     * @return Response
     */
    protected function view($content = null, int $status = Response::HTTP_OK, $context = null)
    {
        if (null == $context) {
            $context = new SerializationContext();
        }

        $context->setSerializeNull(true);
        
        if ($content instanceof JsonView) {
            $content = $content->toArray();
        } else {
            $content = (new JsonView($content, "", $status, []))->toArray();
        }

        $content = $this->serializer->serialize($content, self::RESPONSE_FORMAT, $context);

        return new JsonResponse($content, $status, ['Content-Type' => self::CONTENT_TYPE], true);
    }

    /**
     * Create error message
     *
     * @param ConstraintViolationListInterface $violations
     * @return string
     */
    private function createErrorMessage(ConstraintViolationListInterface $violations): string
    {
        $errors = [];

        foreach ($violations as $violation) {
            $errors[] = [
                'key' => Inflector::tableize($violation->getPropertyPath()),
                'message' => $violation->getMessage()
            ];
        }

        return json_encode(['errors' => $errors]);
    }

    public function getHeaderRequest()
    {
        $headers = [
            'Authorization' => $this->request->headers->get('Authorization'),
            'x-accept-version' => $this->request->headers->get('x-accept-version'),
        ];

        return $headers;
    }
}
