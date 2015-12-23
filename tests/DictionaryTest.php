<?php
/**
 * Created by Érick Carvalho on 16/12/2015.
 */

namespace Tests;

use WordFilter\Dictionary;

/**
 * Teste do gerenciamento do dicionário.
 *
 * Class DictionaryTest
 * @package Tests
 */
class DictionaryTest extends \PHPUnit_Framework_TestCase
{
    public function testConsult()
    {
        Dictionary::queryWord('teste');
    }

    public function testAddWords()
    {
        Dictionary::addWords('maria');
        Dictionary::addWords([
            'você',
            'teste',
            'também',
            'tudo',
            'certo',
            'casa',
            'curto',
            'se',
            'as',
            'correto',
            'apagar1',
            'apagar2',
            'apagar3'
        ]);
    }

    public function testConsultWords()
    {
        $this->assertEquals('você', Dictionary::queryWord('você'));
        $this->assertEquals('maria', Dictionary::queryWord('maria'));
    }

    public function testRemoveWords()
    {
        Dictionary::deleteWords('apagar1');
        Dictionary::deleteWords(['apagar2', 'apagar3']);

        $this->assertNull(Dictionary::queryWord('apagar1'));
        $this->assertNull(Dictionary::queryWord('apagar2'));
        $this->assertNull(Dictionary::queryWord('apagar3'));
    }
}
