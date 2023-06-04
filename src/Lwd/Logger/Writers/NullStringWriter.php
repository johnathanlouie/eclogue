<?php

namespace Lwd\Logger\Writers;

use Lwd\Logger\Log;
use Lwd\Logger\WriterInterface;

/**
 * Log writer that does nothing.
 *
 * @author Johnathan Louie
 */
class NullStringWriter implements WriterInterface {

    /**
     * Does nothing.
     *
     * @param string $payload Log entry as a formatted payload.
     * @param Log $log Structured log entry.
     * @return void
     */
    public function write($payload, $log) {

    }

}
