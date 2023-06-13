<?php

namespace Lwd\Eclogue\Formatters;

use DateTime;
use Exception;
use Lwd\Eclogue\FormatterInterface;
use Lwd\Eclogue\LogEntry;
use Psr\Log\LogLevel;

/**
 * Formatter for the GELF v1.1, short for Graylog Extended Log Format.
 *
 * GELF Payload Specification
 * Version 1.1 (11/2013)
 * A GELF message is a JSON string with the following fields:
 * - `version`: string (UTF-8)
 *     - GELF spec version – “1.1”; MUST be set by the client library.
 * - `host`: string (UTF-8)
 *     - the name of the host, source or application that sent this message;
 *       MUST be set by the client library.
 * - `short_message`: string (UTF-8)
 *     - a short, descriptive message; MUST be set by the client library.
 * - `full_message`: string (UTF-8)
 *     - a long message that can contain a backtrace; optional.
 * - `timestamp`: number
 *     - seconds since UNIX epoch with optional decimal places for milliseconds;
 *       SHOULD be set by the client library. If absent, the timestamp will be
 *       set to the current time (now).
 * - `level`: number
 *     - the level equal to the standard syslog levels; optional. Default is
 *       1 (ALERT).
 * - `facility`: string (UTF-8)
 *     - optional, deprecated. Send as additional field instead.
 * - `line`: number
 *     - the line in a file that caused the error (decimal); optional,
 *       deprecated. Send as an additional field instead.
 * - `file`: string (UTF-8)
 *     - the file (with path, if you want) that caused the error (string);
 *       optional, deprecated. Send as an additional field instead.
 * - `_[additional field]`: string (UTF-8) or number
 *     - every field you send and prefix with an underscore (`_`) will be
 *       treated as an additional field. Allowed characters in field names are
 *       any word character (letter, number, underscore), dashes and dots. The
 *       verifying regular expression is:
 *       ```
 *       ^[\\w\\.\\-]*$
 *       ```
 *       Libraries SHOULD not allow to send id as additional field (`_id`).
 *       Graylog server nodes omit this field automatically.
 *
 * @author Johnathan Louie
 * @link https://go2docs.graylog.org/5-1/getting_in_log_data/gelf.html#GELFPayloadSpecification
 */
class GelfFormatter implements FormatterInterface {

    /** @var int[] Associative array of PSR-3 levels to syslog levels. */
    private static $SYSLOG_LEVELS = [
        LogLevel::EMERGENCY => LOG_EMERG,
        LogLevel::ALERT => LOG_ALERT,
        LogLevel::CRITICAL => LOG_CRIT,
        LogLevel::ERROR => LOG_ERR,
        LogLevel::WARNING => LOG_WARNING,
        LogLevel::NOTICE => LOG_NOTICE,
        LogLevel::INFO => LOG_INFO,
        LogLevel::DEBUG => LOG_DEBUG,
    ];

    /**
     * Formats the log entry into a GELF payload.
     *
     * @param LogEntry $logEntry
     * @return string GELF-formatted JSON string.
     * @throws Exception
     */
    public function format($logEntry) {
        $host = $logEntry->getContext('server_address') ?: filter_input(INPUT_SERVER, 'SERVER_ADDR', FILTER_VALIDATE_IP, FILTER_NULL_ON_FAILURE) ?: '127.0.0.1';

        $timestamp = $logEntry->getContext('timestamp');
        if (!is_int($timestamp) && !is_float($timestamp)) {
            if (is_string($timestamp)) {
                $timestamp = strtotime($timestamp) ?: time();
            } elseif ($timestamp instanceof DateTime) {
                $timestamp = $timestamp->getTimestamp();
            } else {
                $timestamp = time();
            }
        }

        // version, host, short_message are mandatory fields.
        $object = [
            'version' => '1.1',
            'host' => $host,
            'short_message' => $logEntry->getMessage(),
            'timestamp' => $timestamp,
        ];

        if (array_key_exists($logEntry->getLevel(), self::$SYSLOG_LEVELS)) {
            $object['level'] = self::$SYSLOG_LEVELS[$logEntry->getLevel()];
        }

        foreach ($logEntry->getContextKeys() as $k) {
            // _id is illegal.
            // timestamp and server_address were already added.
            if (in_array($k, ['id', 'timestamp', 'server_address'])) {
                continue;
            }

            $v = $logEntry->getContext($k);

            if (is_object($v) && method_exists($v, '__toString')) {
                $v = $v->__toString();
            }

            $object["_{$k}"] = $v;
        }

        $json = json_encode($object, JSON_UNESCAPED_SLASHES);
        if ($json === false) {
            throw new Exception(json_last_error_msg(), json_last_error());
        }
        return $json;
    }

}
