<?php

namespace RdnException;

/**
 * If server received an invalid response from upstream server. The message is public.
 */
class BadGatewayException extends HttpException
{
	protected $code = 502;
}
