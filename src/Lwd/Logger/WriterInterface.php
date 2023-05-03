<?php

namespace Lwd\Logger;

/**
 * Log writer for any output.
 */
interface WriterInterface {

    /**
     * Writes the log entry.
     * 
     * @param string|null $category
     * @param mixed $level
     * @param string $message
     * @param array $context
     * @return void
     */
    public function write($category, $level, $message, $context);
}
