<?php

namespace RdnException\Factory;

use RdnFactory\AbstractFactory;
use Whoops\Handler\HandlerInterface;
use Whoops\Run;

class Whoops extends AbstractFactory
{
	protected function create()
	{
		$run = new Run;

		/** @var HandlerInterface $handler */
		$handler = $this->service('RdnException\Whoops\Handler');
		$run->pushHandler($handler);

		return $run;
	}
}
