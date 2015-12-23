<?php
/**
 * Created by Érick Carvalho on 17/12/2015.
 */

namespace WordFilter\Console\Commands;

use WordFilter\Console\Command;
use WordFilter\Correction;
use WordFilter\Support\Str;

class CorrectorCommand extends Command
{
    /**
     * Lista de palavras a serem corrigidas
     *
     * @var array
     */
    private $wordList = [];

    /**
     * Configuração do comando
     *
     * @return void
     */
    protected function configure()
    {
        $this->setName('corrector')->setDescription('Corretor de palavras.');
    }

    /**
     * Handler de execução do comando
     *
     * @return void
     */
    protected function handle()
    {
        $this->wordList = [];

        $this->writeLine();
        $this->writeLine('Aberto o corretor de palavras.');
        $this->writeLine('Escreva abaixo as palavras a serem corrigidas.');
        $this->writeLine('Comandos predefinidos:');
        $this->writeLine();
        $this->writeLine('  --run   Executa a correção das palavras inseridas.');
        $this->writeLine('  --reset Reseta a lista de palavras inseridas.');
        $this->writeLine('  --list  Exibe as palavras inseridas.');
        $this->writeLine('  --close Retorna ao menu principal.');
        $this->writeLine();

        while(true)
        {
            $line = $this->read();

            if($line === '--reset')
            {
                $this->wordList = [];

                $this->writeLine('Lista de palavras limpa.');
                break;
            }
            elseif($line === '--list')
            {
                $this->writeLine();

                if(count($this->wordList) > 0)
                {
                    $this->writeLine('Abaixo todas as palavras inseridas na lista:');

                    foreach($this->wordList as $word)
                    {
                        $this->writeLine('- '.$word);
                    }
                }
                else
                {
                    $this->writeLine('Nenhuma palavra inserida na lista.');
                }

                break;
            }
            elseif($line === '--close')
            {
                $command = $this->getApplication()->find('menu');
                $command->run($this->input, $this->output);
                break;
            }
            elseif($line === '--run')
            {
                if(count($this->wordList) < 1)
                {
                    $this->writeLine('Nenhuma palavra inserida na lista.');
                }
                else
                {
                    $table = $this->getHelper('table');
                    $table->setHeaders(['Palavra', Str::accents('Sugestão')]);

                    $rows = [];

                    foreach($this->wordList as $word)
                    {
                        $correction = new Correction($word);

                        $caseRemove = $correction->caseRemove();
                        $caseAdd = $correction->caseAdd();
                        $casePop = $correction->casePop();
                        $caseTotal = [];

                        if(!empty($caseRemove))
                        {
                            $caseTotal = array_merge($caseTotal, $caseRemove);
                        }

                        if(!empty($caseAdd))
                        {
                            $caseTotal = array_merge($caseTotal, $caseAdd);
                        }

                        if(!empty($casePop))
                        {
                            $caseTotal = array_merge($caseTotal, $casePop);
                        }

                        if(!empty($caseTotal))
                        {
                            $caseTotal = array_unique($caseTotal);
                        }

                        $total = count($caseTotal);
                        $subTotal = ceil($total / 2);
                        $count = 1;

                        $rows[] = [' ', ' '];

                        if(count($caseTotal) > 0)
                        {
                            foreach($caseTotal as $suggestion)
                            {
                                if(!empty(trim($suggestion)))
                                {
                                    if($count++ == $subTotal || $total == 1)
                                    {
                                        $rows[] = [$word, Str::accents($suggestion)];
                                    }
                                    else
                                    {
                                        $rows[] = [' ', Str::accents($suggestion)];
                                    }
                                }
                            }
                        }
                        else
                        {
                            $rows[] = [$word, ' '];
                        }
                    }

                    $table->setRows($rows);
                    $table->render($this->output);
                }
            }
            elseif(!preg_match('/^[A-Za-záàâãéèêíïóôõöúçñÁÀÂÃÉÈÍÏÓÔÕÖÚÇÑ]+$/i', $line))
            {
                $this->writeLine('- Digite somente letras.');
            }
            else
            {
                if(!in_array($line, $this->wordList))
                {
                    $this->wordList[] = $line;
                }
            }
        }

        $this->handle();
    }
}