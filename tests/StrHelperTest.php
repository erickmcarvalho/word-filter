<?php
/**
 * Created by Érick Carvalho on 16/12/2015.
 */

namespace Tests;

use WordFilter\Support\Str;

/**
 * Teste da helper de string.
 *
 * Class StrTest
 * @package Tests
 */
class StrHelperTest extends \PHPUnit_Framework_TestCase
{
    public function testRemoveAccents()
    {
        $this->assertEquals('voce', Str::withoutAccents('você'));
        $this->assertTrue(Str::length(Str::withoutAccents('você')) === 4);
    }
}
