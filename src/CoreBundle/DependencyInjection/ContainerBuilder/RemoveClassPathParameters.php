<?php

namespace Microservice\CoreBundle\DependencyInjection\ContainerBuilder;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class RemoveClassPathParameters implements CompilerPassInterface {

    /**
     * You can modify the container here before it is dumped to PHP code.
     *
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container) {
        $parameterBag = $container->getParameterBag();
        foreach ($parameterBag->all() as $parameterName => $value) {
            if(preg_match('/\.class$/', $parameterName)) {
                $parameterBag->remove($parameterName);
            }
        }
    }
}