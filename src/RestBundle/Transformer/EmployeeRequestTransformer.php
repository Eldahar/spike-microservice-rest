<?php

namespace Microservice\RestBundle\Transformer;

use Microservice\CoreBundle\Interfaces\RequestValidatorInterface;
use Symfony\Component\HttpFoundation\Request;

use Microservice\CoreBundle\Interfaces\RequestTransformerInterface;
use Microservice\RestBundle\DataObject\Employee;

class EmployeeRequestTransformer implements RequestTransformerInterface {
    /**
     * @var RequestValidatorInterface
     */
    protected $validator;

    /**
     * @param RequestValidatorInterface $validator
     */
    public function __construct(RequestValidatorInterface $validator) {
        $this->validator = $validator;
    }

    public function transform(Request $request) {
        $this->validator->validate($request);
        $employee = new Employee();
        $employee->setName($request->get('name'));

        return $employee;
    }
}