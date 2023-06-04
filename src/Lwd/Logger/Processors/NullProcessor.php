<?php

namespace Lwd\Logger\Processors;

use Lwd\Logger\LogEntry;
use Lwd\Logger\ProcessorInterface;

/**
 * Processor that does nothing.
 *
 * @author Johnathan Louie
 */
class NullProcessor implements ProcessorInterface {

    /**
     * Returns the log entry without modifying it.
     *
     * @param LogEntry $logEntry
     * @return LogEntry Unmodified log.
     */
    public function process($logEntry) {
        return $logEntry;
    }

}
