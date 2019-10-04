<?php

namespace Prophecy\Router\Exceptions;

use Throwable;

class MethodDoesNotExistsException extends \Exception {

    public function __construct($className,$code = 0, Throwable $previous = null)
    {
        parent::__construct("Method does not exists on class {$className}.", $code, $previous);
    }
}