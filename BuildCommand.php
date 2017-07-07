#!/usr/bin/env php
<?php

require __DIR__.'/vendor/autoload.php';

use Symfony\Component\Console\Application;

class BuildCommand extends \Microservice\CoreBundle\Command\AbstractBuildCommand {

    protected function execute(\Symfony\Component\Console\Input\InputInterface $input, \Symfony\Component\Console\Output\OutputInterface $output) {
        $environment = $input->getOption(self::OPTION_ENV);
        $this->baseDir = __DIR__;

        $this->generateContainer($environment);
        $this->generateRoute();
    }

    /**
     * @param $parameterBag
     * @return \Symfony\Component\DependencyInjection\ContainerBuilder
     */
    protected function createBuilder($parameterBag): \Symfony\Component\DependencyInjection\ContainerBuilder {
        $builder = new \Symfony\Component\DependencyInjection\ContainerBuilder($parameterBag);

        $builder->addCompilerPass(new \Symfony\Component\DependencyInjection\Compiler\RepeatedPass([
            new \Symfony\Component\DependencyInjection\Compiler\AnalyzeServiceReferencesPass(),
            new \Microservice\CoreBundle\DependencyInjection\ContainerBuilder\RemoveUnusedDefinitionPass()
        ]));
        $builder->addCompilerPass(new \Symfony\Component\DependencyInjection\Compiler\ResolveClassPass());
        $builder->addCompilerPass(new \Microservice\CoreBundle\DependencyInjection\ContainerBuilder\RemoveClassPathParameters(), \Symfony\Component\DependencyInjection\Compiler\PassConfig::TYPE_REMOVE);

        $builder->addCompilerPass(new \Symfony\Component\DependencyInjection\Compiler\RemovePrivateAliasesPass());
        $builder->addCompilerPass(new \Symfony\Component\DependencyInjection\Compiler\ReplaceAliasByActualDefinitionPass());
        $builder->addCompilerPass(new \Symfony\Component\DependencyInjection\Compiler\RemoveAbstractDefinitionsPass());

        $builder->addCompilerPass(new \Symfony\Component\Routing\DependencyInjection\RoutingResolverPass());

        return $builder;
    }
}

$application = new Application();
$application->add(new BuildCommand());
$application->run();