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
			'e400' => <<<HTML
<p>
	Request cannot be fulfilled due to bad syntax.
</p>
HTML
			, 'e401' => <<<HTML
<p>
	Authentication is possible but has failed.
</p>
HTML
			, 'e403' => <<<HTML
<p>
	You are not authorized to access this page.
</p>
HTML
			, 'e404' => <<<HTML
<p>
	The page you're trying to reach doesn't exist.
</p>
HTML
			, 'e405' => <<<HTML
<p>
	Request method not supported by that resource.
</p>
HTML
			, 'e422' => <<<HTML
<p>
	Request unable to be followed due to semantic errors.
</p>
HTML
			, 'e500' => <<<HTML
<h2>Report Error</h2>
<p>
	Please contact <a href="mailto:email@example.org">email@example.org</a> to report the problem.
</p>
HTML
			, 'e502' => <<<HTML
<p>
	Server received an invalid response from upstream server.
</p>
HTML
		),

		'templates' => array(
			'e4xx' => 'rdn-exception/error/4xx',
			'e403' => 'rdn-exception/error/403',
			'e404' => 'rdn-exception/error/404',
			'e5xx' => 'rdn-exception/error/5xx',
			'e500' => 'rdn-exception/error/500',
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
