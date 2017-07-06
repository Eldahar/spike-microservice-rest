<?php

namespace Microservice\CoreBundle\Interfaces;

use Symfony\Component\HttpFoundation\Request;

interface RequestTransformerInterface {
    public function transform(Request $request);
}