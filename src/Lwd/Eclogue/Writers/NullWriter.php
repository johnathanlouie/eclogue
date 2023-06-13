<?php

namespace Lwd\Eclogue\Writers;

use Lwd\Eclogue\LogEntry;
use Lwd\Eclogue\WriterInterface;

/**
 * Log writer that does nothing.
 *
 * @author Johnathan Louie
 */
class NullWriter implements WriterInterface {

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
