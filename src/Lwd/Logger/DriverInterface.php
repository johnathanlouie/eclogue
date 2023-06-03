<?php

namespace Lwd\Logger;

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
     * @param Log $log
     * @return void
     * @throws Exception
     */
    public function log($log);
}
