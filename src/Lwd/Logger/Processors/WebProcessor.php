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
        $logEntry->addContextIfNotExist('client_address', filter_input(INPUT_SERVER, 'REMOTE_ADDR', FILTER_VALIDATE_IP, FILTER_NULL_ON_FAILURE));
        $logEntry->addContextIfNotExist('server_address', filter_input(INPUT_SERVER, 'SERVER_ADDR', FILTER_VALIDATE_IP, FILTER_NULL_ON_FAILURE));
        $logEntry->addContextIfNotExist('request_url', filter_input(INPUT_SERVER, 'REQUEST_URI'));
        $logEntry->addContextIfNotExist('query_string', filter_input(INPUT_SERVER, 'QUERY_STRING'));
        $logEntry->addContextIfNotExist('http_method', filter_input(INPUT_SERVER, 'REQUEST_METHOD'));
        return $logEntry;
    }

}
