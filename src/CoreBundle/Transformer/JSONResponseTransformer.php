<?php

namespace Microservice\CoreBundle\Transformer;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

use Microservice\CoreBundle\Interfaces\ResponseTransformerInterface;

class JSONResponseTransformer implements ResponseTransformerInterface {

    public function transform($responseData): Response {
        if(!is_array($responseData)) {
            throw new \InvalidArgumentException('The responseData is not array!');
        }

        return new JsonResponse($responseData);
    }
}