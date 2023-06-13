<?php

namespace Lwd\Eclogue\Drivers;

use Lwd\Eclogue\DriverInterface;
use Lwd\Eclogue\LogEntry;

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
