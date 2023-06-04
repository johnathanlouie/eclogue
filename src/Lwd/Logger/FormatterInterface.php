<?php

namespace Lwd\Logger;

/**
 * Log formatter that returns logs as strings.
 *
 * @author Johnathan Louie
 */
interface FormatterInterface {

    /**
     * Formats a log entry into a string.
     *
     * @param LogEntry $logEntry
     * @return string Formatted log.
     */
    public function format($logEntry);
}
