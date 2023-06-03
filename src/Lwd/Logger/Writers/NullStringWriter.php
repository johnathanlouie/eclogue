<?php

namespace Lwd\Logger\Writers;

use Lwd\Logger\StringWriterInterface;

/**
 * Log writer that does nothing.
 *
 * @author Johnathan Louie
 */
class NullStringWriter implements StringWriterInterface {

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
