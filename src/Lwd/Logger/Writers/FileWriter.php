<?php

namespace Lwd\Logger\Writers;

use ErrorException;
use Lwd\Logger\Log;
use Lwd\Logger\StringWriterInterface;

/**
 * Simple log writer for a monolithic file.
 *
 * @author Johnathan Louie
 */
class FileWriter implements StringWriterInterface {

    /** @var string File path to log file. */
    private $filename;

    /**
     * Constructs the log writer.
     *
     * @param string $filename The file to write to.
     */
    public function __construct($filename) {
        $this->filename = $filename;
    }

    /**
     * Writes the log entry to the file.
     *
     * @param Log $log
     * @param string $formatted Formatted string to be written.
     * @return void
     * @throws ErrorException
     */
    public function write($log, $formatted) {
        try {
            set_error_handler(function ($errno, $errstr, $errfile, $errline) {
                throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
            });

            $byteCount = file_put_contents($this->filename, $formatted . PHP_EOL, FILE_APPEND);
            if ($byteCount === false) {
                throw new ErrorException("Failed to write log entry to '{$this->filename}'");
            }
        } catch (ErrorException $e) {
            throw $e;
        } finally {
            restore_error_handler();
        }
    }

}
