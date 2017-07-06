<?php

namespace Microservice\CoreBundle\Interfaces;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

interface RestControllerInterface {
    /**
     * @param Request $request
     * @return Response
     */
    public function restAction(Request $request) : Response;
}