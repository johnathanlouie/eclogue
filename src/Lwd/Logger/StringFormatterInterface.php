<?php

namespace Lwd\Logger;

/**
 * Log formatter that turns logs into one string.
 *
 * @author Johnathan Louie
 */
interface StringFormatterInterface {

    /**
     * Formats a log entry into a string.
     *
     * @param Log $log
     * @return string Formatted log.
     */
    public function format($log);
}
