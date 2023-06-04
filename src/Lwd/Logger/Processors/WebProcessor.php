<?php

namespace Lwd\Logger\Processors;

use Lwd\Logger\LogEntry;
use Lwd\Logger\ProcessorInterface;

/**
 * Log data processor for adding data from the current web request.
 *
 * @author Johnathan Louie
 */
class WebProcessor implements ProcessorInterface {

    /**
     * Injects URL, HTTP method, and remote IP of the current web request.
     *
     * @param LogEntry $logEntry
     * @return LogEntry Modified log.
     */
    public function process($logEntry) {
        $logEntry->clientAddress = filter_input(INPUT_SERVER, 'REMOTE_ADDR', FILTER_VALIDATE_IP, FILTER_NULL_ON_FAILURE);
        $logEntry->serverAddress = filter_input(INPUT_SERVER, 'SERVER_ADDR', FILTER_VALIDATE_IP, FILTER_NULL_ON_FAILURE);
        $logEntry->serverAddress = filter_input(INPUT_SERVER, 'REQUEST_URI');
        $logEntry->serverAddress = filter_input(INPUT_SERVER, 'QUERY_STRING');
        $logEntry->serverAddress = filter_input(INPUT_SERVER, 'REQUEST_METHOD');
        return $logEntry;
    }

}
