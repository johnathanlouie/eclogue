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
     * @param Log $log
     * @param string $formatted
     * @return void
     * @throws Exception
     */
    public function write($log, $formatted);
}
