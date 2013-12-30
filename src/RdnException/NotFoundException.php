<?php

namespace RdnException;

/**
 * If server was unable to locate the requested resource. The message is public.
 */
class NotFoundException extends HttpException
{
	protected $code = 404;
}
