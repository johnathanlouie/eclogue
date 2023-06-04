<?php

namespace Lwd\Logger\Writers;

use Lwd\Logger\LogEntry;
use Lwd\Logger\WriterInterface;

/**
 * Log writer that does nothing.
 *
 * @author Johnathan Louie
 */
class NullStringWriter implements WriterInterface {

    /**
     * Does nothing.
     *
     * @param string $payload Log entry as a formatted payload.
     * @param LogEntry $logEntry Structured log entry.
     * @return void
     */
    public function write($payload, $logEntry) {

    }

}
