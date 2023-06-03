<?php

namespace Lwd\Logger\Drivers;

use Lwd\Logger\DriverInterface;

/**
 * Does nothing.
 *
 * @author jlouie
 */
class NullDriver implements DriverInterface {

    /**
     * @inheritDoc
     */
    public function log($log) {

    }

}
