<?php

namespace RdnException;

/**
 * If request cannot be fulfilled due to bad syntax. The message is public.
 */
class BadRequestException extends HttpException
{
	protected $code = 400;
}
