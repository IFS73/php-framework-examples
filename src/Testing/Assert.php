<?php

namespace Cda0521Framework\Testing;

use Cda0521Framework\Exception\AssertionFailedException;

/**
 * Handles assertions in unit testing
 */
final class Assert
{
    /**
     * Handles exceptions when condition is not met
     *
     * @param mixed $given The actual value
     * @param boolean $condition The condition to be evaluated
     * @param string $errorMessage The message to display if the condition was not met
     * @return void
     * @static
     */
    static private function _assert($given, bool $condition, string $errorMessage): void {
        if (!$condition) {
            throw new AssertionFailedException($given, $errorMessage);
        }
    }

    /**
     * Asserts if given confition is false
     *
     * @param boolean $condition The condition to evaluate
     * @return void
     * @static
     */
    static public function isTrue(bool $condition): void {
        self::_assert($condition, $condition, 'is true');
    }

    /**
     * Asserts whether given value is an array
     *
     * @param mixed $value The value to evaluate
     * @return void
     * @static
     */
    static public function isArray($value): void {
        self::_assert($value, is_array($value), 'is an array');
    }

    /**
     * Asserts whether two values are equsl
     *
     * @param mixed $expected The expected value
     * @param mixed $given The given value
     * @return void
     * @static
     */
    static public function isEqual($expected, $given): void {
        self::_assert($given, $expected === $given, 'matches expected ' . var_export($expected, true));
    }

    /**
     * Asserts whether a value is an instance of a given class
     *
     * @param mixed $value The value to evaluate
     * @param string $className The full class name to test the value against
     * @return void
     */
    static public function isInstanceOf($value, string $className): void {
        self::_assert($value, $value instanceof $className, 'is an instance of class ' . $className);
    }
}
