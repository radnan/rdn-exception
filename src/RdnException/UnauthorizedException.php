<?php

namespace RdnException;

/**
 * If authentication is possible but has failed. The message is public.
 */
class UnauthorizedException extends HttpException
{
	protected $code = 401;
}
