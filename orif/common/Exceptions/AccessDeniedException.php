<?php

namespace Common\Exceptions;

use CodeIgniter\Exceptions\HTTPExceptionInterface;
use CodeIgniter\Exceptions\DebugTraceableTrait;
use CodeIgniter\Exceptions\ExceptionInterface;
use RuntimeException;

class AccessDeniedException extends RuntimeException implements
    ExceptionInterface, HTTPExceptionInterface
{
    use DebugTraceableTrait;

    /**
     * HTTP status code
     *
     * @var int
     */
    protected $code = 403;

    public static function forPageAccessDenied(?string $message = null)
    {
        return new static($message
            ?? lang('user_lang.msg_err_access_denied_message'));
    }
}
