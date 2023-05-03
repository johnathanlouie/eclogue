<?php

namespace Lwd\Logger\Writers;

use DateTimeInterface;
use Lwd\Logger\WriterInterface;

/**
 * Simple log writer for a monolithic file.
 */
class FileWriter implements WriterInterface {

    /** @var string */
    private $filename;

    /**
     * Constructs the log writer.
     * 
     * @param string $filename The file to write to.
     */
    public function __construct($filename = '/var/log/apache2/error.log') {
        $this->filename = $filename;
    }

    /**
     * Writes the log entry to a file.
     * 
     * @param string|null $category
     * @param mixed $level
     * @param string $message
     * @param array $context
     * @return void
     */
    public function write($category, $level, $message, $context) {
        $timestamp = date_create()->format(DateTimeInterface::RFC3339_EXTENDED);
        $category = is_null($category) ? '' : "$category.";
        $level = strtoupper($level);
        $context = json_encode($context);
        $entry = sprintf('[%s] %s%s: %s %s', $timestamp, $category, $level, $message, $context);
        file_put_contents($this->filename, $entry, FILE_APPEND);
    }

}
