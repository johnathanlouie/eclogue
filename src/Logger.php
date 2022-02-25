<?php

namespace Lwd\Logger;

use Psr\Log\LoggerInterface;
use Psr\Log\InvalidArgumentException;
use Psr\Log\AbstractLogger;
use Psr\Log\LoggerTrait;
use Psr\Log\LogLevel;
use Lwd\Logger\Writers\FileWriter;
use Exception;

/**
 * PSR-3 compliant logger.
 * Use different log writers to extend the functionality.
 * 
 * @see WriterInterface
 */
class Logger extends AbstractLogger implements LoggerInterface
{
    use LoggerTrait;

    const LOG_LEVELS = [
        LogLevel::EMERGENCY,
        LogLevel::ALERT,
        LogLevel::CRITICAL,
        LogLevel::ERROR,
        LogLevel::WARNING,
        LogLevel::NOTICE,
        LogLevel::INFO,
        LogLevel::DEBUG,
    ];

    /** @var WriterInterface Log writer. */
    protected $writer;

    /** @var string|null Logging category. */
    protected $category;

    /**
     * Constructs the logger.
     * 
     * @param WriterInterface $writer Log writer.
     * @param string|null $category Loging category.
     */
    public function __construct($writer = null, $category = null)
    {
        if (is_null($writer)) {
            $writer = new FileWriter();
        }
        $this->writer = $writer;
        $this->category = $category;
    }

    /**
     * Replaces message placeholders with context.
     * 
     * @param string $message
     * @param array $context
     */
    protected function interpolate($message, $context = [])
    {
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
     * Logs with an arbitrary level.
     *
     * @param mixed $level PSR-3 log level.
     * @param string $message
     * @param array $context
     * @return void
     * @throws InvalidArgumentException If not PSR-3 log level, or exception not in 'exception'.
     */
    public function log($level, $message, $context = [])
    {
        // Must be a PSR-3 level.
        if (!in_array($level, static::LOG_LEVELS)) {
            throw new InvalidArgumentException('Not a PSR-3 log level');
        }

        // Exceptions must be in the 'exception' key.
        // Only exceptions can be in the 'exception' key.
        foreach ($context as $k => $v) {
            if ($v instanceof Exception && $k !== 'exception') {
                throw new InvalidArgumentException("Exceptions must be in 'exceptions'");
            }
        }

        $message = $this->interpolate($message, $context);
        $this->writer->write($this->category, $level, $message, $context);
    }
}
