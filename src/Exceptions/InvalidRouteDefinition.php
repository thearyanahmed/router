<?php

namespace Prophecy\Router\Exception;

use \Exception;
use Throwable;

class InvalidRouteDefinition extends \Exception
{
    public function __construct($message = "Invalid Route Definition.Check class & method name", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}