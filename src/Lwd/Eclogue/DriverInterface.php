<?php

namespace Lwd\Eclogue;

use Exception;

/**
 * Handler that processes, formats, and writes logs.
 *
 * @author Johnathan Louie
 */
interface DriverInterface {

    /**
     * Handles logs.
     *
     * @param LogEntry $logEntry
     * @return void
     * @throws Exception
     */
    public function log($logEntry);
}
