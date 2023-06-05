<?php

namespace Lwd\Logger\Writers;

use ErrorException;
use Exception;
use Lwd\Logger\LogEntry;
use Lwd\Logger\WriterInterface;

/**
 * Simple log writer for a monolithic file.
 *
 * @author Johnathan Louie
 */
class FileWriter implements WriterInterface {

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
     * @param string $payload Log entry as a formatted payload.
     * @param LogEntry $logEntry Structured log entry.
     * @return void
     * @throws ErrorException
     */
    public function write($payload, $logEntry) {
        try {
            set_error_handler(function ($errno, $errstr, $errfile, $errline) {
                throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
            });

            $this->mkdir();
            $byteCount = file_put_contents($this->filename, $payload . PHP_EOL, FILE_APPEND);
            if ($byteCount === false) {
                throw new ErrorException("Failed to write log entry to '{$this->filename}'");
            }
        } catch (Exception $e) {
            throw $e;
        } finally {
            restore_error_handler();
        }
    }

    /**
     * Creates the parent directories if they do not exist.
     *
     * @return void
     * @throws Exception On failure to create directory.
     */
    private function mkdir() {
        if (!is_file($this->filename)) {
            $dirname = dirname($this->filename);
            if (!is_dir($dirname)) {
                if (!mkdir($dirname, 0777, true)) {
                    throw new Exception("Failed to make '{$dirname}' directory");
                }
            }
        }
    }

}
