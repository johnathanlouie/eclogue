<?php

namespace Lwd\Logger\Drivers;

use Lwd\Logger\FormatterInterface;
use Lwd\Logger\ProcessorInterface;
use Lwd\Logger\WriterInterface;

/**
 * Configurable logging driver.
 *
 * @author Johnathan Louie
 */
class Driver {

    /** @var ProcessorInterface[] */
    private $processors = [];

    /** @var FormatterInterface */
    private $formatter;

    /** @var WriterInterface */
    private $writer;

    /**
     * Constructs the logging driver.
     *
     * @param array $processors
     * @param FormatterInterface $formatter
     * @param WriterInterface $writer
     */
    public function __construct($processors, $formatter, $writer) {
        $this->processors = $processors;
        $this->formatter = $formatter;
        $this->writer = $writer;
    }

    /**
     * @inheritDoc
     */
    public function log($logEntry) {
        foreach ($this->processors as $processor) {
            $logEntry = $processor->process($logEntry);
        }
        $payload = $this->formatter->format($logEntry);
        $this->writer->write($payload, $logEntry);
    }

}
