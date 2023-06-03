<?php

namespace Lwd\Logger;

/**
 * Processor for logs.
 *
 * @author Johnathan Louie
 */
interface ProcessorInterface {

    /**
     * Modify log data.
     *
     * @param Log $log
     * @return Log Modified log.
     */
    public function process($log);
}
