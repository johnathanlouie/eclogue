<?php

namespace Lwd\Logger;

use Exception;

/**
 * Log writer for any output.
 *
 * @author Johnathan Louie
 */
interface WriterInterface {

    /**
     * Writes the log entry.
     *
     * @param string $payload Log entry as a formatted payload.
     * @param LogEntry $logEntry Structured log entry.
     * @return void
     * @throws Exception
     */
    public function write($payload, $logEntry);
}
