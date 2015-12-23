<?php
/**
 * Created by Érick Carvalho on 17/12/2015.
 */

namespace Tests;

use WordFilter\Correction;

/**
 * Teste co corretor com consulta no dicionário.
 *
 * Class CorrectionFinalTest
 * @package Tests
 */
class CorrectionFinalTest extends \PHPUnit_Framework_TestCase
{
    public function testCaseRemove()
    {
        $this->assertContains('a', (new Correction('sa'))->caseRemove());
        $this->assertContains('se', (new Correction('ses'))->caseRemove());
        $this->assertContains('as', (new Correction('sas'))->caseRemove());
        $this->assertContains('tudo', (new Correction('tudod'))->caseRemove());
        $this->assertContains('tudo', (new Correction('rtudo'))->caseRemove());
        $this->assertContains('maria', (new Correction('maaria'))->caseRemove());
    }

    public function testCaseAdd()
    {
        $this->assertContains('curto', (new Correction('crto'))->caseAdd());
        $this->assertContains('certo', (new Correction('crto'))->caseAdd());
        $this->assertContains('certo', (new Correction('erto'))->caseAdd());
        $this->assertContains('correto', (new Correction('corret'))->caseAdd());
        $this->assertContains('você', (new Correction('vóc'))->caseAdd());
        $this->assertContains('também', (new Correction('tmbem'))->caseAdd());
        $this->assertContains('também', (new Correction('tamem'))->caseAdd());
    }

    public function testCasePop()
    {
        $this->assertContains('certo', (new Correction('carto'))->casePop());
        $this->assertContains('tudo', (new Correction('tcdo'))->casePop());
        $this->assertContains('casa', (new Correction('masa'))->casePop());
    }

    public function testNotContains()
    {
        $attempt = (new Correction('hortgrafea'));

        $this->assertNotContains('ortografia', $attempt->caseRemove());
        $this->assertNotContains('ortografia', $attempt->caseAdd());
        $this->assertNotContains('ortografia', $attempt->casePop());

        $this->assertNotContains('voce', (new Correction('vóc'))->caseAdd());
        $this->assertNotContains('tambem', (new Correction('tamem'))->caseAdd());
    }
}
