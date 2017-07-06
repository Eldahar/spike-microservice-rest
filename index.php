<?php

require __DIR__."/vendor/autoload.php";
require __DIR__."/container.php";
require __DIR__."/route.php";

\Symfony\Component\Debug\Debug::enable();

$request = Symfony\Component\HttpFoundation\Request::createFromGlobals();

$context = new \Symfony\Component\Routing\RequestContext();
$context->fromRequest($request);

$urlMatcher = new ProjectUrlMatcher($context);
$route = $urlMatcher->matchRequest($request);

$container = new MyContainer();
/** @var \Microservice\CoreBundle\Interfaces\RestControllerInterface $controller */
$controller = $container->get($route['_controller']);

$controller->restAction($request)->send();
