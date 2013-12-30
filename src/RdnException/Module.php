<?php

namespace RdnException;

use Zend\ModuleManager\ModuleManager;
use Zend\Mvc\MvcEvent;

class Module
{
	public function getConfig()
	{
		return include __DIR__ .'/../../config/module.config.php';
	}

	public function init(ModuleManager $modules)
	{
		$modules->loadModule('RdnEvent');
		$modules->loadModule('RdnFactory');
	}

	public function onBootstrap(MvcEvent $event)
	{
		if (PHP_SAPI == 'cli')
		{
			return;
		}

		$app = $event->getApplication();
		$services = $app->getServiceManager();
		$events = $app->getEventManager();

		$events->detach($services->get('Zend\Mvc\View\ExceptionStrategy'));
		$events->detach($services->get('Zend\Mvc\View\RouteNotFoundStrategy'));
	}
}
