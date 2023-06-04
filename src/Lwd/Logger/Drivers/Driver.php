<?php

namespace Lwd\Logger\Drivers;

use Lwd\Logger\ProcessorInterface;
use Lwd\Logger\StringFormatterInterface;
use Lwd\Logger\WriterInterface;

/**
 * Configurable logging driver.
 *
 * @author Johnathan Louie
 */
class Driver {

    /** @var ProcessorInterface[] */
    private $processors = [];

    /** @var StringFormatterInterface */
    private $formatter;

    /** @var WriterInterface */
    private $writer;

    /**
     * Constructs the logging driver.
     *
     * @param array $processors
     * @param StringFormatterInterface $formatter
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
    public function log($log) {
        foreach ($this->processors as $processor) {
            $log = $processor->process($log);
        }
        $formatted = $this->formatter->format($log);
        $this->writer->write($log, $formatted);
    }

}
