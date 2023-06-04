<?php

namespace Lwd\Logger;

/**
 * Processor for logs.
 *
 * @author Johnathan Louie
 */
interface ProcessorInterface {

    /**
     * Modifies log data.
     *
     * @param LogEntry $logEntry
     * @return LogEntry Modified log.
     */
    public function process($logEntry);
}
