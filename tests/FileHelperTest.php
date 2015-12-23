<?php
/**
 * Created by Érick Carvalho on 16/12/2015.
 */

namespace Tests;

use WordFilter\Support\File;

/**
 * Teste da helper de arquivo.
 *
 * Class FileHelperTest
 * @package Tests
 */
class FileHelperTest extends \PHPUnit_Framework_TestCase
{
    public function testFileExists()
    {
        $this->assertTrue(File::exists('storage/'));
    }
}
