<?php
/**
 * Created by Érick Carvalho on 16/12/2015.
 */

namespace Tests;

use WordFilter\Dictionary;

/**
 * Teste de conexão com o dicionário.
 *
 * Class DictionarySchemaTest
 * @package Tests
 */
class DictionarySchemaTest extends \PHPUnit_Framework_TestCase
{
    public function testBuildSchema()
    {
        $this->assertTrue(Dictionary::testConnection());
    }
}
