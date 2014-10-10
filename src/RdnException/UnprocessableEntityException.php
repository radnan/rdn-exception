<?php

namespace RdnException;

/**
 * If request unable to be followed due to semantic errors. The message is public.
 */
class UnprocessableEntityException extends HttpException
{
	protected $code = 422;
}
