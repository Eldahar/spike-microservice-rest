<?php

namespace Microservice\RestBundle\Validator;

use Microservice\CoreBundle\Interfaces\RequestValidatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegisterEmployeeValidator implements RequestValidatorInterface {

    public function validate(Request $request): void {
        $content = $request->request->all();
        $resolver = new OptionsResolver();
        $resolver->setRequired(['name']);
        $resolver->addAllowedTypes('name', 'string');
        $resolver->resolve($content);
    }
}