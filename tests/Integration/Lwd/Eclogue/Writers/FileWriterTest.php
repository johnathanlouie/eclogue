<?php

namespace Integration\Lwd\Eclogue\Writers;

use Exception;
use Faker\Factory;
use Lwd\Eclogue\LogEntry;
use Lwd\Eclogue\Writers\FileWriter;
use PHPUnit\Framework\TestCase;

/**
 * @author Johnathan Louie
 */
class FileWriterTest extends TestCase {

    /**
     * @covers \Lwd\Eclogue\LogEntry::__construct
     * @covers \Lwd\Eclogue\Writers\FileWriter::__construct
     * @covers \Lwd\Eclogue\Writers\FileWriter::mkdir
     * @covers \Lwd\Eclogue\Writers\FileWriter::write
     * @throws Exception
     */
    public function testWrite() {
        $faker = Factory::create();
        self::rrmdir('/fake');
        self::assertFalse(is_dir('/fake'), '/fake should not exist yet');
        $filepath = '/fake/logs/test1.txt';
        $fileContentsExpected = '';

        $writer = new FileWriter($filepath);
        for ($i = 1; $i <= 3; $i++) {
            $text = $faker->realText();
            $fileContentsExpected .= $text . PHP_EOL;
            $writer->write($text, new LogEntry('', ''));
            self::assertFileExists($filepath, "'{$filepath}' should exist on try {$i}");
            $fileContentsActual = file_get_contents($filepath);
            self::assertNotFalse($fileContentsActual, "Failed to read '{$filepath}' on try {$i}");
            self::assertSame($fileContentsExpected, $fileContentsActual, "'{$filepath}' contents did not match on try {$i}");
        }

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
