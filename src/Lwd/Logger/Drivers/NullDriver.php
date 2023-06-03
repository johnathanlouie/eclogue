<?php

namespace Lwd\Logger\Drivers;

use Lwd\Logger\DriverInterface;
use Lwd\Logger\Log;

/**
 * Log driver that does nothing.
 *
 * @author Johnathan Louie
 */
class NullDriver implements DriverInterface {

    /**
     * Does nothing.
     *
     * @param Log $log
     * @return void
     */
    public function log($log) {

    }

}
