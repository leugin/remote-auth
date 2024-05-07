<?php

namespace Leugin\RemoteAuth\Exceptions;

class NotFoundException extends \DomainException
{
    public function __construct($message = 'Not found',  $code = 404, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}