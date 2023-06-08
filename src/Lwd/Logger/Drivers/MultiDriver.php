<?php

namespace Lwd\Logger\Drivers;

use Exception;
use Lwd\Logger\DriverInterface;

/**
 * Log driver that runs multiple drivers sequentially. All drivers will attempt to run even if exceptions happen to
 * the earlier drivers.
 *
 * @author Johnathan Louie
 */
class MultiDriver implements DriverInterface {

    /** @var DriverInterface[] List of log drivers. */
    private $drivers;

    /**
     * Constructs the driver.
     *
     * @param DriverInterface[] $drivers
     */
    public function __construct($drivers) {
        $this->drivers = $drivers;
    }

    /**
     * @inheritDoc
     */
    public function log($logEntry) {
        foreach ($this->drivers as $driver) {
            try {
                $driver->log($logEntry);
            } catch (Exception $e) {
                // TODO: Log internally.
            }
        }
    }
}
