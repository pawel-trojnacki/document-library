<?php

declare(strict_types=1);

namespace App\Shared\Application\Exception;

abstract class RuntimeException extends \RuntimeException
{
    public function __construct(string $message = '', int $code = 0, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
