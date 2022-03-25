<?php

namespace Internexus\Larapid\Exceptions;

use RuntimeException;

class EntityNotFoundException extends RuntimeException
{
    public function __construct($name)
    {
        $this->message = "Entity '{$name}' not found";
    }
}
