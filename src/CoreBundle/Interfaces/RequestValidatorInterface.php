<?php

namespace Microservice\CoreBundle\Interfaces;

use Symfony\Component\HttpFoundation\Request;

interface RequestValidatorInterface {
    public function validate(Request $request) : void;
}