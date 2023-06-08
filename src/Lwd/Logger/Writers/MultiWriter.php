<?php

namespace Lwd\Logger\Writers;

use Exception;
use Lwd\Logger\WriterInterface;

/**
 * Log driver that runs multiple drivers sequentially. All drivers will attempt to run even if exceptions happen to
 * the earlier drivers.
 *
 * @author Johnathan Louie
 */
class MultiWriter implements WriterInterface {

    /** @var WriterInterface[] List of log drivers. */
    private $writers;

    /**
     * Constructs the driver.
     *
     * @param WriterInterface[] $writers
     */
    public function __construct($writers) {
        $this->writers = $writers;
    }

    /**
     * @inheritDoc
     */
    public function write($payload, $logEntry) {
        foreach ($this->writers as $writer) {
            try {
                $writer->write($payload, $logEntry);
            } catch (Exception $e) {
                // TODO: Log internally.
            }
        }
    }
}
