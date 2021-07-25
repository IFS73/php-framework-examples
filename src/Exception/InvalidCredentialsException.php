<?php

namespace Cda0521Framework\Exception;

class InvalidCredentialsException extends \Exception
{
    const WRONG_EMAIL = 0;
    const WRONG_PASSWORD = 1;

    protected int $type;

    public function __construct(string $message, int $type)
    {
        parent::__construct($message);

        $this->type = $type;
    }

    /**
     * Get the value of type
     */ 
    public function getType()
    {
        return $this->type;
    }
}
