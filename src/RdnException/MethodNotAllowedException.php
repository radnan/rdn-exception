<?php

namespace RdnException;

/**
 * If request method not supported by that resource. The message is public.
 */
class MethodNotAllowedException extends HttpException
{
	protected $code = 405;
}
