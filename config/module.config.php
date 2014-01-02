<?php

return array(
	'rdn_event' => array(
		'listeners' => array(
			'RdnException:ExceptionStrategy',
		),
	),

	'rdn_event_listeners' => array(
		'factories' => array(
			'RdnException:ExceptionStrategy' => 'RdnException\Factory\Listener\ExceptionStrategy',
		),
	),

	'rdn_exception' => array(
		'messages' => array(
			'e403' => <<<HTML
<p>
	You are not authorized to access this page.
</p>
HTML
			, 'e404' => <<<HTML
<p>
	The page you're trying to reach doesn't exist.
</p>
HTML
			, 'e500' => <<<HTML
<h2>Report Error</h2>
<p>
	Please contact <a href="mailto:email@example.org">email@example.org</a> to report the problem.
</p>
HTML
		),

		'templates' => array(
			'e403' => 'rdn-exception/error/403',
			'e404' => 'rdn-exception/error/404',
			'e500' => 'rdn-exception/error/500',
		),

		'whoops' => array(
//			'editor' => 'sublime',
		),
	),

	'view_manager' => array(
		'display_exceptions' => false,

		'template_path_stack' => array(
			'RdnException' => dirname(__DIR__) .'/views'
		),
	),

	'service_manager' => array(
		'factories' => array(
			'RdnException\Whoops' => 'RdnException\Factory\Whoops',
			'RdnException\Whoops\Handler' => 'RdnException\Factory\Whoops\Handler',
		),
	),
);
