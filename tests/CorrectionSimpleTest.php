<?php
/**
 * Created by Érick Carvalho on 16/12/2015.
 */

namespace Tests;

use WordFilter\Correction;

/**
 * Teste simples do corretor.
 *
 * Class CorrectionSimpleTest
 * @package Tests
 */
class CorrectionSimpleTest extends \PHPUnit_Framework_TestCase
{
    public function testCaseRemove()
    {
        $this->assertContains('a', (new Correction('sa'))->caseRemove(false));
        $this->assertContains('se', (new Correction('ses'))->caseRemove(false));
        $this->assertContains('as', (new Correction('sas'))->caseRemove(false));
        $this->assertContains('tudo', (new Correction('tudod'))->caseRemove(false));
        $this->assertContains('tudo', (new Correction('rtudo'))->caseRemove(false));
        $this->assertContains('maria', (new Correction('maaria'))->caseRemove(false));
    }

    public function testCaseAdd()
    {
        $this->assertContains('curto', (new Correction('crto'))->caseAdd(false));
        $this->assertContains('certo', (new Correction('crto'))->caseAdd(false));
        $this->assertContains('certo', (new Correction('erto'))->caseAdd(false));
        $this->assertContains('correto', (new Correction('corret'))->caseAdd(false));
        $this->assertContains('voce', (new Correction('vóc'))->caseAdd(false));
        $this->assertContains('tambem', (new Correction('tmbem'))->caseAdd(false));
        $this->assertContains('tambem', (new Correction('tamem'))->caseAdd(false));
    }

    public function testCasePop()
    {
        $this->assertContains('certo', (new Correction('carto'))->casePop(false));
        $this->assertContains('tudo', (new Correction('tcdo'))->casePop(false));
        $this->assertContains('casa', (new Correction('masa'))->casePop(false));
    }

    public function testNotContains()
    {
        $attempt = (new Correction('hortgrafea'));

        $this->assertNotContains('ortografia', $attempt->caseRemove(false));
        $this->assertNotContains('ortografia', $attempt->caseAdd(false));
        $this->assertNotContains('ortografia', $attempt->casePop(false));
    }
}
