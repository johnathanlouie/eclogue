<?php

namespace Lwd\Eclogue\Drivers;

use Lwd\Eclogue\DriverInterface;
use Lwd\Eclogue\FormatterInterface;
use Lwd\Eclogue\ProcessorInterface;
use Lwd\Eclogue\WriterInterface;

/**
 * Configurable logging driver.
 *
 * @author Johnathan Louie
 */
class Driver implements DriverInterface {

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
