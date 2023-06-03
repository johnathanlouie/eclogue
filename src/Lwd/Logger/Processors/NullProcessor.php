<?php

namespace Lwd\Logger\Processors;

use Lwd\Logger\ProcessorInterface;

/**
 * Processor that does nothing.
 *
 * @author Johnathan Louie
 */
class NullProcessor implements ProcessorInterface {

    /**
     * Returns the log entry without modifying it.
     *
     * @param Log $log
     * @return Log Unmodified log.
     */
    public function process($log) {
        return $log;
    }

}
