<?php

namespace Microservice\CoreBundle\Interfaces;

use Symfony\Component\HttpFoundation\Response;

interface ResponseTransformerInterface {
    public function transform($responseData) : Response;
}