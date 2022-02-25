<?php

namespace Lwd\Logger;

use Psr\Log\LoggerInterface;

/**
 * Static wrapper for a PSR-3 compliant logger.
 * 
 * @see self::setLogger() Must be called before use.
 */
class Log
{
    /** @var LoggerInterface */
    protected static $logger;

    /**
     * Sets the PSR-3 compliant logger to be used.
     * 
     * @param LoggerInterface $logger
     * @return void
     */
    public static function setLogger($logger)
    {
        static::$logger = $logger;
    }

    /**
     * System is unusable.
     *
     * @param string $message
     * @param array $context
     * @return void
     */
    public static function emergency($message, $context = [])
    {
        static::$logger->emergency($message, $context);
    }

    /**
     * Action must be taken immediately.
     *
     * Example: Entire website down, database unavailable, etc. This should
     * trigger the SMS alerts and wake you up.
     *
     * @param string $message
     * @param array $context
     * @return void
     */
    public static function alert($message, $context = [])
    {
        static::$logger->alert($message, $context);
    }

    /**
     * Critical conditions.
     *
     * Example: Application component unavailable, unexpected exception.
     *
     * @param string $message
     * @param array $context
     * @return void
     */
    public static function critical($message, $context = [])
    {
        static::$logger->critical($message, $context);
    }

    /**
     * Runtime errors that do not require immediate action but should typically
     * be logged and monitored.
     *
     * @param string $message
     * @param array $context
     * @return void
     */
    public static function error($message, $context = [])
    {
        static::$logger->error($message, $context);
    }

    /**
     * Exceptional occurrences that are not errors.
     *
     * Example: Use of deprecated APIs, poor use of an API, undesirable things
     * that are not necessarily wrong.
     *
     * @param string $message
     * @param array $context
     * @return void
     */
    public static function warning($message, $context = [])
    {
        static::$logger->warning($message, $context);
    }

    /**
     * Normal but significant events.
     *
     * @param string $message
     * @param array $context
     * @return void
     */
    public static function notice($message, $context = [])
    {
        static::$logger->notice($message, $context);
    }

    /**
     * Interesting events.
     *
     * Example: User logs in, SQL logs.
     *
     * @param string $message
     * @param array $context
     * @return void
     */
    public static function info($message, $context = [])
    {
        static::$logger->info($message, $context);
    }

    /**
     * Detailed debug information.
     *
     * @param string $message
     * @param array $context
     * @return void
     */
    public static function debug($message, $context = [])
    {
        static::$logger->debug($message, $context);
    }

    /**
     * Logs with an arbitrary level.
     *
     * @param mixed $level
     * @param string $message
     * @param array $context
     * @return void
     */
    public static function log($level, $message, $context = [])
    {
        static::$logger->log($level, $message, $context);
    }
}
