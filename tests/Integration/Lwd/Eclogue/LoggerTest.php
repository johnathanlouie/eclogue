<?php

namespace Integration\Lwd\Eclogue;

use Exception;
use Lwd\Eclogue\Drivers\Driver;
use Lwd\Eclogue\Drivers\MultiDriver;
use Lwd\Eclogue\Drivers\NullDriver;
use Lwd\Eclogue\Formatters\GelfFormatter;
use Lwd\Eclogue\Logger;
use Lwd\Eclogue\Processors\NullProcessor;
use Lwd\Eclogue\Processors\WebProcessor;
use Lwd\Eclogue\Writers\FileWriter;
use Lwd\Eclogue\Writers\MultiWriter;
use Lwd\Eclogue\Writers\NullWriter;
use PHPUnit\Framework\TestCase;

/**
 * @author Johnathan Louie
 */
class LoggerTest extends TestCase {

    /**
     * @covers \Lwd\Eclogue\Drivers\Driver
     * @covers \Lwd\Eclogue\Drivers\MultiDriver
     * @covers \Lwd\Eclogue\Drivers\NullDriver
     * @covers \Lwd\Eclogue\Formatters\GelfFormatter
     * @covers \Lwd\Eclogue\LogEntry
     * @covers \Lwd\Eclogue\Logger
     * @covers \Lwd\Eclogue\Processors\NullProcessor
     * @covers \Lwd\Eclogue\Processors\WebProcessor
     * @covers \Lwd\Eclogue\Writers\FileWriter
     * @covers \Lwd\Eclogue\Writers\MultiWriter
     * @covers \Lwd\Eclogue\Writers\NullWriter
     * @throws Exception
     */
    public function testWrite() {
        self::rrmdir('/fake');
        self::assertFalse(is_dir('/fake'), '/fake should not exist yet');
        $filepath = '/fake/logs/test1.txt';
        $fileContentsExpected = '';

        $processors = [
            new NullProcessor(),
            new WebProcessor(),
        ];
        $formatter = new GelfFormatter();
        $writers = [
            new NullWriter(),
            new FileWriter($filepath),
        ];
        $writer = new MultiWriter($writers);
        $drivers = [
            new NullDriver(),
            new Driver($processors, $formatter, $writer),
        ];
        $driver = new MultiDriver($drivers);
        $logger = new Logger($driver);

        $category = $logger->getCategory();
        self::assertSame(null, $category, 'Default category should be null');
        $logger->emergency('What is a message?', ['timestamp' => 0]);
        $fileContentsExpected .= '{"version":"1.1","host":"127.0.0.1","short_message":"What is a message?","timestamp":0,"level":0,"_category":null,"_client_address":false,"_request_url":null,"_query_string":null,"_http_method":null}' . PHP_EOL;
        self::assertFileExists($filepath, "Emergency log should create '{$filepath}'");
        $fileContentsActual = file_get_contents($filepath);
        self::assertNotFalse($fileContentsActual, "Failed to read '{$filepath}' after logging emergency");
        self::assertSame($fileContentsExpected, $fileContentsActual, "'{$filepath}' contents did not match after logging emergency");

        $logger->setCategory('new_category');
        $category = $logger->getCategory();
        self::assertSame('new_category', $category, 'Updated category should be new_category');
        $logger->alert("\t\n\v\f\r !\"#$%&'()*+,-./0123456789:;<=>?@ABCDEFGHIJKLMNOPQRSTUVWXYZ[\\]^_`abcdefghijklmnopqrstuvwxyz{|}~", ['timestamp' => 123.456]);
        $fileContentsExpected .= '{"version":"1.1","host":"127.0.0.1","short_message":"\t\n\u000b\f\r !\"#$%&\'()*+,-./0123456789:;<=>?@ABCDEFGHIJKLMNOPQRSTUVWXYZ[\\\\]^_`abcdefghijklmnopqrstuvwxyz{|}~","timestamp":123.456,"level":1,"_category":"new_category","_client_address":false,"_request_url":null,"_query_string":null,"_http_method":null}' . PHP_EOL;
        self::assertFileExists($filepath, "Alert log should create '{$filepath}'");
        $fileContentsActual = file_get_contents($filepath);
        self::assertNotFalse($fileContentsActual, "Failed to read '{$filepath}' after logging alert");
        self::assertSame($fileContentsExpected, $fileContentsActual, "'{$filepath}' contents did not match after logging alert");

        self::rrmdir('/fake');
        self::assertFalse(is_dir('/fake'), 'Cleaning up /fake failed');
    }

    /**
     * Recursively deletes files and subdirectories in a directory.
     *
     * @param string $dir
     * @return void
     */
    private static function rrmdir($dir) {
        if (is_dir($dir)) {
            $objects = scandir($dir);
            foreach ($objects as $object) {
                if ($object != '.' && $object != '..') {
                    $filename = $dir . DIRECTORY_SEPARATOR . $object;
                    if (is_dir($filename) && !is_link($filename)) {
                        self::rrmdir($filename);
                    } else {
                        unlink($filename);
                    }
                }
            }
            rmdir($dir);
        }
    }

}
