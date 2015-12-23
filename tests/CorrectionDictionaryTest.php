<?php
/**
 * Created by Érick Carvalho on 16/12/2015.
 */

namespace Tests;

use WordFilter\Correction;
use WordFilter\Dictionary;
use WordFilter\Support\Str;

/**
 * Teste de consulta do dicionário através do corretor.
 *
 * Class CorrectionDictionaryTest
 * @package Tests
 */
class CorrectionDictionaryTest extends \PHPUnit_Framework_TestCase
{
    public function testOneSuggestion()
    {
        $attempt = (new Correction('vtce'))->casePop(false);
        $result = [];

        $this->assertContains('voce', $attempt, 'Attempt failed');

        foreach($attempt as $word)
        {
            $consult = Dictionary::queryWord($word);

            if($consult !== null)
            {
                $result[] = $consult;
            }
        }

        $this->assertContains(Str::accents('você'), $result, 'Consult failed');
    }

    public function testNotSuggestion()
    {
        $attempt = (new Correction('hortgrafea'));

        $this->assertNotContains('ortografia', $attempt->caseRemove(false));
        $this->assertNotContains('ortografia', $attempt->caseAdd(false));
        $this->assertNotContains('ortografia', $attempt->casePop(false));
    }
}
