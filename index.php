<?php

require_once __DIR__."/vendor/autoload.php";
require_once __DIR__."/container.php";
require_once __DIR__."/route.php";

\Symfony\Component\Debug\Debug::enable();

$request = Symfony\Component\HttpFoundation\Request::createFromGlobals();

$context = new \Symfony\Component\Routing\RequestContext();
$context->fromRequest($request);

$urlMatcher = new ProjectUrlMatcher($context);
$route = $urlMatcher->matchRequest($request);

$container = new MyContainer();

if(in_array($container->getParameter('environment'), ['local', 'dev'])) {
    \Symfony\Component\Debug\Debug::enable();
}

/** @var \Microservice\CoreBundle\Interfaces\RestControllerInterface $controller */
$controller = $container->get($route['_controller']);

$controller->restAction($request)->send();
