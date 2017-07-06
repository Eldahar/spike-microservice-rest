<?php

namespace Microservice\RestBundle\Handler;

use Microservice\CoreBundle\Interfaces\MatchingHandlerInterface;
use Microservice\RestBundle\DataObject\Employee;

class RegisterEmployeeHandler {
    /**
     * @var MatchingHandlerInterface
     */
    protected $matchingHandler;

    /**
     * @param MatchingHandlerInterface $matchingHandler
     */
    public function __construct(MatchingHandlerInterface $matchingHandler) {
        $this->matchingHandler = $matchingHandler;
    }

    public function handle(Employee $employee): array {
        $response = [
            'registration' => ['name' => $employee->getName()],
            'matching' => $this->matchingHandler->match()
        ];

        return $response;
    }
}