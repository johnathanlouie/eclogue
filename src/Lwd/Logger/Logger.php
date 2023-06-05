<?php

namespace Lwd\Logger;

use Exception;
use Lwd\Logger\Drivers\Driver;
use Psr\Log\AbstractLogger;
use Psr\Log\InvalidArgumentException;
use Psr\Log\LoggerTrait;
use Psr\Log\LogLevel;

/**
 * PSR-3 compliant logger.
 * Use different log drivers or swap driver components to extend the functionality.
 * for the full interface specification.
 *
 * @see DriverInterface
 * @see Driver
 *
 * The message MUST be a string or object implementing __toString().
 *
 * The message MAY contain placeholders in the form: {foo} where foo
 * will be replaced by the context data in key "foo".
 *
 * The context array can contain arbitrary data, the only assumption that
 * can be made by implementors is that if an Exception instance is given
 * to produce a stack trace, it MUST be in a key named "exception".
 *
 * @link https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-3-logger-interface.md
 */
class Logger extends AbstractLogger {

    use LoggerTrait;

    private static $LOG_LEVELS = [
        LogLevel::EMERGENCY,
        LogLevel::ALERT,
        LogLevel::CRITICAL,
        LogLevel::ERROR,
        LogLevel::WARNING,
        LogLevel::NOTICE,
        LogLevel::INFO,
        LogLevel::DEBUG,
    ];

    /** @var DriverInterface Log driver. */
    private $driver;

    /** @var string|null Logging category. */
    private $category = null;

    /**
     * Constructs the logger.
     *
     * @param DriverInterface $driver Log driver.
     */
    public function __construct($driver) {
        $this->driver = $driver;
    }

    /**
     * Replaces message placeholders with context.
     *
     * @param string $message
     * @param array $context
     */
    private function interpolate($message, $context = []) {
        // Build a replacement array with braces around the context keys.
        $replace = [];
        foreach ($context as $key => $val) {
            // Check that the value can be cast to string.
            if (!is_array($val) && (!is_object($val) || method_exists($val, '__toString'))) {
                $replace['{' . $key . '}'] = $val;
            }
        }

        // Interpolate replacement values into the message and return.
        return strtr($message, $replace);
    }

    /**
     * @inheritDoc
     */
    public function log($level, $message, array $context = []) {
        // Must be a PSR-3 level.
        if (!in_array($level, self::$LOG_LEVELS)) {
            throw new InvalidArgumentException('Must be a PSR-3 log level');
        }

        // Exceptions must be in the 'exception' key.
        foreach ($context as $k => $v) {
            if ($v instanceof Exception && $k !== 'exception') {
                throw new InvalidArgumentException("If an Exception object is passed in the context data, it MUST be in the 'exception' key");
            }
        }

        try {
            $newMessage = $this->interpolate($message, $context);
            $logEntry = new LogEntry($newMessage, $level);
            $logEntry->setContext('category', $this->category);
            $logEntry->addContextArray($context);
            $this->driver->log($logEntry);
        } catch (Exception $e) {
            // Ignore internal exceptions.
        }
    }

    /**
     * Sets the logging category, also known as channel.
     *
     * @param string|null $category
     * @return void
     */
    public function setCategory($category) {
        $this->category = $category;
    }

    /**
     * Gets the logging category, also known as channel.
     *
     * @return string|null
     */
    public function getCategory() {
        return $this->category;
    }

}
