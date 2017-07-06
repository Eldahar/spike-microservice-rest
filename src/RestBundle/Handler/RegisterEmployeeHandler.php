<?php

namespace Microservice\RestBundle\Handler;

use Microservice\CoreBundle\Interfaces\MatchingHandlerInterface;

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

    public function handle(): array {
        $response = [
            'registration' => ['datas...'],
            'matching' => $this->matchingHandler->match()
        ];

        return $response;
    }
}