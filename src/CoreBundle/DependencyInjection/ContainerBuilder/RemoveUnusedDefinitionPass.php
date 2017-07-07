<?php

namespace Microservice\CoreBundle\DependencyInjection\ContainerBuilder;

use Symfony\Component\DependencyInjection\Compiler\RepeatablePassInterface;
use Symfony\Component\DependencyInjection\Compiler\RepeatedPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class RemoveUnusedDefinitionPass implements RepeatablePassInterface {
    private $repeatedPass;

    /**
     * {@inheritdoc}
     */
    public function setRepeatedPass(RepeatedPass $repeatedPass)
    {
        $this->repeatedPass = $repeatedPass;
    }

    /**
     * Processes the ContainerBuilder to remove unused definitions.
     *
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        $graph = $container->getCompiler()->getServiceReferenceGraph();

        $hasChanged = false;
        foreach ($container->getDefinitions() as $id => $definition) {
            if($definition->hasTag('protected')) {
                continue;
            }

            if ($graph->hasNode($id)) {
                $edges = $graph->getNode($id)->getInEdges();
                $referencingAliases = array();
                $sourceIds = array();
                foreach ($edges as $edge) {
                    $node = $edge->getSourceNode();
                    $sourceIds[] = $node->getId();

                    if ($node->isAlias()) {
                        $referencingAliases[] = $node->getValue();
                    }
                }
                $isReferenced = (count(array_unique($sourceIds)) - count($referencingAliases)) > 0;
            } else {
                $referencingAliases = array();
                $isReferenced = false;
            }

            if (1 === count($referencingAliases) && false === $isReferenced) {
                $container->setDefinition((string) reset($referencingAliases), $definition);
                $definition->setPublic(true);
                $container->removeDefinition($id);
                $container->log($this, sprintf('Removed service "%s"; reason: replaces alias %s.', $id, reset($referencingAliases)));
            } elseif (0 === count($referencingAliases) && false === $isReferenced) {
                $container->removeDefinition($id);
                $container->resolveEnvPlaceholders(serialize($definition));
                $container->log($this, sprintf('Removed service "%s"; reason: unused.', $id));
                $hasChanged = true;
            }
        }

        if ($hasChanged) {
            $this->repeatedPass->setRepeat();
        }
    }
}