<?php

namespace Lwd\Logger;

/**
 * Handler that processes, formats, and writes logs.
 *
 * @author Johnathan Louie
 */
interface DriverInterface {

    /**
     * Handles logs.
     *
     * @param Log $log
     * @return void
     */
    public function log($log);
}
