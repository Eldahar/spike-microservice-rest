<?php

namespace Microservice\RestBundle\DataObject;

class Employee {
    /**
     * @var string
     */
    protected $name;

    public function getName(): string {
        return $this->name;
    }

    public function setName(string $name) {
        $this->name = $name;
    }
}