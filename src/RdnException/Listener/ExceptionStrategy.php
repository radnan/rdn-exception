<?php

namespace RdnException\Listener;

use RdnException;
use Whoops\Run;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;
use Zend\Mvc\Application;
use Zend\Mvc\MvcEvent;
use Zend\Stdlib\CallbackHandler;
use Zend\Stdlib\ResponseInterface;
use Zend\View\Model\ViewModel;

class ExceptionStrategy implements ListenerAggregateInterface
{
	/**
	 * @var bool
	 */
	protected $exceptionDisplayed;

	/**
	 * @var Run
	 */
	protected $whoops;

	/**
	 * @var array
	 */
	protected $messages = array();

	/**
	 * @var array
	 */
	protected $templates = array();

	/**
	 * @var CallbackHandler[]
	 */
	protected $listeners = array();

	/**
	 * @param boolean $flag
	 */
	public function setIsExceptionDisplayed($flag)
	{
		$this->exceptionDisplayed = $flag;
	}

	/**
	 * @return boolean
	 */
	public function isExceptionDisplayed()
	{
		return $this->exceptionDisplayed;
	}

	public function setWhoops(Run $whoops)
	{
		$this->whoops = $whoops;
	}

	/**
	 * @return Run
	 */
	public function getWhoops()
	{
		return $this->whoops;
	}

	public function setMessages(array $messages = array())
	{
		$this->messages = $messages;
	}

	/**
	 * @return array
	 */
	public function getMessages()
	{
		return $this->messages;
	}

	public function setTemplates(array $template = array())
	{
		$this->templates = $template;
	}

	/**
	 * @return array
	 */
	public function getTemplates()
	{
		return $this->templates;
	}

	public function attach(EventManagerInterface $events)
	{
		$this->listeners[] = $events->attach(MvcEvent::EVENT_DISPATCH_ERROR, array($this, 'detectError'), 100);
		$this->listeners[] = $events->attach(MvcEvent::EVENT_DISPATCH_ERROR, array($this, 'prepareViewModel'), -95);

		$this->listeners[] = $events->attach(MvcEvent::EVENT_RENDER_ERROR, array($this, 'detectError'), 100);
		$this->listeners[] = $events->attach(MvcEvent::EVENT_RENDER_ERROR, array($this, 'prepareViewModel'), -95);
	}

	public function detach(EventManagerInterface $events)
	{
		foreach ($this->listeners as $index => $listener)
		{
			if ($events->detach($listener))
			{
				unset($this->listeners[$index]);
			}
		}
	}

	public function detectError(MvcEvent $event)
	{
		$result = $event->getResult();
		if ($result instanceof ResponseInterface)
		{
			// Already have a response as the result
			return;
		}

		$error = $event->getError();
		$ex = $event->getParam('exception');

		switch ($error)
		{
			case Application::ERROR_CONTROLLER_NOT_FOUND:
				$message = ucfirst($event->getControllerClass());
				$ex = new RdnException\RuntimeException($message, 500, $ex);
				break;
			case Application::ERROR_CONTROLLER_INVALID:
				$message = $event->getController() .' is not dispatchable';
				$ex = new RdnException\RuntimeException($message, 500, $ex);
				break;
			case Application::ERROR_ROUTER_NO_MATCH:
				$message = 'Request did not match any routes.';
				$ex = new RdnException\NotFoundException($message, 404, $ex);
				break;
		}

		if (isset($message))
		{
			if ($ex->getCode() == 500)
			{
				$event->setError(Application::ERROR_EXCEPTION);
			}
			$event->setParam('exception', $ex);
		}
	}

	public function prepareViewModel(MvcEvent $event)
	{
		$result = $event->getResult();
		if ($result instanceof ResponseInterface)
		{
			// Already have a response as the result
			return;
		}

		$ex = $event->getParam('exception');
		if (!$ex instanceof \Exception)
		{
			return;
		}

		/** @var \Zend\Http\Response $response */
		$response = $event->getResponse();

		if ($ex instanceof RdnException\HttpException)
		{
			$response->setStatusCode($ex->getCode());
		}
		else
		{
			$code = $response->getStatusCode();
			if ($code === 200)
			{
				$response->setStatusCode(500);
			}
		}

		$match = $event->getRouteMatch();
		if ($handler = array_shift($this->whoops->getHandlers()))
		{
			$handler->addDataTable('Route match', $match ? $match->getParams() : array());
		}

		$model = new ViewModel(array(
			'exceptionMessage' => $ex->getMessage(),
			'displayExceptions' => false,
			'whoops' => $this->whoops,
			'exception' => $ex,
			'helpMessage' => $this->messages['e'. $response->getStatusCode()],
		));
		$model->setTemplate($this->templates['e'. $response->getStatusCode()]);
		$event->setResult($model);

		if ($this->exceptionDisplayed)
		{
			$model->setVariable('displayExceptions', true);
		}
	}
}
