RdnException
============

The **RdnException** ZF2 module normalizes all framework errors to use native PHP Exceptions.

Two exception classes to handle HTTP response are included with the module:
* `RdnException\AccessDeniedException` - Throwing this exception will result in a **403** response.
* `RdnException\BadGatewayException` - Throwing this exception will result in a **502** response.
* `RdnException\BadRequestException` - Throwing this exception will result in a **400** response.
* `RdnException\MethodNotAllowedException` - Throwing this exception will result in a **405** response.
* `RdnException\NotFoundException` - Throwing this exception will result in a **404** response.
* `RdnException\UnauthorizedException` - Throwing this exception will result in a **401** response.
* `RdnException\UnprocessableEntityException` - Throwing this exception will result in a **422** response.

All other exceptions will result in a **500** response.

Additionally a third class `RdnException\PublicException` is included for cases where you'd like to display the exception message to the user. All HTTP exceptions extend from this class.

## How to install

1. Use `composer` to require the `radnan/rdn-exception` package:

   ~~~bash
   $ composer require radnan/rdn-exception:1.*
   ~~~

2. Activate the module by including it in your `application.config.php` file:

   ~~~php
   <?php

   return array(
       'modules' => array(
           'RdnException',
           // ...
       ),
   );
   ~~~

## How to use

Most of the configuration is done using the `rdn_exception` option.

You can customize the **messages** that are shown to the user if exceptions are not displayed. And finally you can control the **templates** used for exception type.

Exceptions are sorted by their HTTP status code. The following is an example configuration:

~~~php
<?php

return array(
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
	),

	'view_manager' => array(
		'display_exceptions' => false,
	),
);
~~~
