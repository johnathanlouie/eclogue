<?php

namespace Lwd\Logger\Writers;

use Faker\Factory;
use Lwd\Logger\LogEntry;
use PHPUnit\Framework\TestCase;

/**
 * @author Johnathan Louie
 */
class FileWriterTest extends TestCase {

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
            $writer->write($text, self::getMockBuilder(LogEntry::class));
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
