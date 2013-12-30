<?php

namespace RdnException\Factory\Listener;

use RdnException\Listener;
use RdnFactory\AbstractFactory;
use Whoops\Run;

class ExceptionStrategy extends AbstractFactory
{
	protected function create()
	{
		$listener = new Listener\ExceptionStrategy;

		/** @var Run $whoops */
		$whoops = $this->service('RdnException\Whoops');
		$listener->setWhoops($whoops);

		$config = $this->config();
		$listener->setMessages($config['rdn_exception']['messages']);
		$listener->setTemplates($config['rdn_exception']['templates']);
		$listener->setIsExceptionDisplayed($config['view_manager']['display_exceptions']);

		return $listener;
	}
}
