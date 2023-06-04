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
     * @param Log $log
     * @param string $formatted
     * @return void
     */
    public function write($log, $formatted) {

    }

}
