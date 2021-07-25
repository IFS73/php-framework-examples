<?php

namespace Cda0521Framework\Exception;

/**
 * Exception class used when unit tests fail
 */
final class AssertionFailedException extends \Exception {
    /**
     * Create new assertion failed exception
     *
     * @param mixed $given The actual value
     * @param string $errorMessage The message to display
     */
    public function __construct($given, string $errorMessage) {
        parent::__construct('Failed to assert that given ' . var_export($given, true) . ' ' . $errorMessage . '.');
    }
}
