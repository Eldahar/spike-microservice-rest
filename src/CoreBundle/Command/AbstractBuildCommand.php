<?php

namespace Microservice\CoreBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\DependencyInjection\Dumper\PhpDumper;

abstract class AbstractBuildCommand extends Command {
    const OPTION_ENV = 'env';

    const CONFIG_DIR = 'config';
    const BASE_SERVICES_FILE = 'services.yml';
    const CONTAINER_FILE = 'container.php';
    const CONTAINER_CLASS = 'MyContainer';
    const ROUTING_CONFIG = 'routing.yml';
    const ROUTING_FILE = 'route.php';

    /**
     * @var string
     */
    protected $baseDir;

    protected function configure() {
        $this->setName('ms:build');
        $this->addOption(self::OPTION_ENV, 'e', \Symfony\Component\Console\Input\InputArgument::OPTIONAL, 'Emvironment', 'dev');
    }

    /**
     * @param $environment
     */
    protected function generateContainer($environment): void {
        $builder = $this->createContainerBuilder();
        $this->loadContainerConfigs($builder, $environment);
        $builder->compile();
        $this->generateContainerFile($builder);
    }

    protected function generateRoute(): void {
        $routeCollection = $this->loadRoutingConfigs();
        $this->generateRouteFile($routeCollection);
    }

    /**
     * @return \Symfony\Component\DependencyInjection\ContainerBuilder
     */
    protected function createContainerBuilder(): \Symfony\Component\DependencyInjection\ContainerBuilder {
        $parameterBag = new \Symfony\Component\DependencyInjection\ParameterBag\ParameterBag();
        $builder = $this->createBuilder($parameterBag);

        return $builder;
    }

    /**
     * @param $builder
     * @param $environment
     */
    protected function loadContainerConfigs($builder, $environment): void {
        $loader = new \Symfony\Component\DependencyInjection\Loader\YamlFileLoader(
            $builder,
            new \Symfony\Component\Config\FileLocator(__DIR__)
        );
        $loader->load(sprintf('%s/%s/%s', $this->baseDir, self::CONFIG_DIR , self::BASE_SERVICES_FILE));
        $loader->load(sprintf('%s/%s/config_%s.yml', $this->baseDir, self::CONFIG_DIR, $environment));
    }

    /**
     * @param $builder
     */
    protected function generateContainerFile($builder): void {
        $dumper = new PhpDumper($builder);
        file_put_contents(sprintf('%s/%s', $this->baseDir, self::CONTAINER_FILE), $dumper->dump(['class' => self::CONTAINER_CLASS]));
    }

    /**
     * @return \Symfony\Component\Routing\RouteCollection
     */
    protected function loadRoutingConfigs(): \Symfony\Component\Routing\RouteCollection {
        $routeFileLocator = new \Symfony\Component\Config\FileLocator(__DIR__);
        $routeLoader = new \Symfony\Component\Routing\Loader\YamlFileLoader($routeFileLocator);
        $routeCollection = $routeLoader->load(sprintf('%s/%s/%s', $this->baseDir, self::CONFIG_DIR,  self::ROUTING_CONFIG));

        return $routeCollection;
    }

    /**
     * @param $routeCollection
     */
    protected function generateRouteFile($routeCollection): void {
        $routeDumper = new \Symfony\Component\Routing\Matcher\Dumper\PhpMatcherDumper($routeCollection);
        file_put_contents(sprintf('%s/%s', $this->baseDir, self::ROUTING_FILE), $routeDumper->dump());
    }

    abstract protected function createBuilder($parameterBag): \Symfony\Component\DependencyInjection\ContainerBuilder;
}