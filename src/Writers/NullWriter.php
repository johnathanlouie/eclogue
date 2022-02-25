<?php

namespace Lwd\Logger\Writers;

use Lwd\Logger\WriterInterface;

/**
 * Log writer for NOP.
 */
class NullWriter implements WriterInterface
{
    /**
     * Writes the log entry to a file.
     * 
     * @param string|null $category
     * @param mixed $level
     * @param string $message
     * @param array $context
     * @return void
     */
    public function write($category, $level, $message, $context)
    {
    }
}
