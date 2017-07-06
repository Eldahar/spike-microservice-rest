<?php

namespace Microservice\RestBundle\Handler;

use Microservice\CoreBundle\Interfaces\MatchingHandlerInterface;

class QuickMatchingHandler implements MatchingHandlerInterface {

    public function match() {
        return [ 'quick match' ];
    }
}