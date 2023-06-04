<?php

namespace Lwd\Logger\Drivers;

use Lwd\Logger\DriverInterface;
use Lwd\Logger\LogEntry;

/**
 * Log driver that does nothing.
 *
 * @author Johnathan Louie
 */
class NullDriver implements DriverInterface {

    /**
     * Does nothing.
     *
     * @param LogEntry $logEntry
     * @return void
     */
    public function log($logEntry) {

    }

}
