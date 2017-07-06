<?php

namespace Microservice\RestBundle\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Microservice\RestBundle\Handler\RegisterEmployeeHandler;
use Microservice\CoreBundle\Interfaces\RestControllerInterface;

class RegisterEmloyeeController implements RestControllerInterface {
    /**
     * @var RegisterEmployeeHandler
     */
    protected $handler;

    /**
     * @param RegisterEmployeeHandler $handler
     */
    public function __construct(RegisterEmployeeHandler $handler) {
        $this->handler = $handler;
    }

    public function restAction(Request $request) : Response {
        return new JsonResponse(
            $this->handler->handle()
        );
    }
}