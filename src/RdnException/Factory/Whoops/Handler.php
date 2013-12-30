<?php

namespace RdnException\Factory\Whoops;

use RdnFactory\AbstractFactory;
use Whoops\Handler\PrettyPageHandler;

class Handler extends AbstractFactory
{
	protected function create()
	{
		$handler = new PrettyPageHandler;

		$config = $this->config('rdn_exception', 'whoops');
		if (isset($config['editor']))
		{
			$handler->setEditor($config['editor']);
		}

		return $handler;
	}
}
