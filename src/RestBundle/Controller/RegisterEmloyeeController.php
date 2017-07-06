<?php

namespace Microservice\RestBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Microservice\CoreBundle\Interfaces\RequestTransformerInterface;
use Microservice\CoreBundle\Interfaces\ResponseTransformerInterface;
use Microservice\RestBundle\Handler\RegisterEmployeeHandler;
use Microservice\CoreBundle\Interfaces\RestControllerInterface;

class RegisterEmloyeeController implements RestControllerInterface {
    /**
     * @var RegisterEmployeeHandler
     */
    protected $handler;

    /**
     * @var RequestTransformerInterface
     */
    protected $requestTransformer;

    /**
     * @var ResponseTransformerInterface
     */
    protected $responseTransformer;

    /**
     * @param RegisterEmployeeHandler $handler
     * @param RequestTransformerInterface $requestTransformer
     * @param ResponseTransformerInterface $responseTransformer
     */
    public function __construct(RegisterEmployeeHandler $handler,
                                RequestTransformerInterface $requestTransformer,
                                ResponseTransformerInterface $responseTransformer
    ) {
        $this->handler = $handler;
        $this->requestTransformer = $requestTransformer;
        $this->responseTransformer = $responseTransformer;
    }

    public function restAction(Request $request) : Response {
        return $this->responseTransformer->transform(
            $this->handler->handle(
                $this->requestTransformer->transform($request)
            )
        );
    }
}