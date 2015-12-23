<?php
/**
 * Created by Érick Carvalho on 17/12/2015.
 */

namespace WordFilter\Console\Commands;

use WordFilter\Console\Command;
use WordFilter\Dictionary as Database;

/**
 * Comando de gerenciamento do dicionário.
 *
 * Class DictionaryManagerCommand
 * @package WordFilter\Console\Commands
 */
class DictionaryManagerCommand extends Command
{
    /**
     * Configura o comando
     *
     * @return void
     */
    protected function configure()
    {
        $this->setName('dictionary')->setDescription('Gerenciador do dicionário.');
    }

    /**
     * Executa o comando
     *
     * @return void
     */
    protected function handle()
    {
        $this->writeLine();
        $this->writeLine('Aberto gerenciador do dicionário.');
        $this->standBy();
    }

    /**
     * Ação: Adicionar palavras ao dicionário
     *
     * @return void
     */
    private function addWords()
    {
        $this->writeLine();
        $this->writeLine('Escreva abaixo as palavras a serem adicionadas.');
        $this->writeLine('Em seguida, digite o comando "--save" para salvar as alterações ou "--cancel" para cancelar.');

        $wordList = [];

        while(true)
        {
            $line = $this->read();

            if($line == '--save')
            {
                if(count($wordList) > 0)
                {
                    Database::addWords($wordList);

                    $this->writeLine('Adicionado '.count($wordList).' palavra'.(count($wordList) > 1 ? 's' : '').' ao dicionário.');
                    break;
                }
            }
            elseif(trim($line) == '--cancel')
            {
                $this->writeLine('Operação cancelada.');
                break;
            }
            else
            {
                $wordList[] = $line;
            }
        }

        $this->writeLine();
        $this->standBy();
    }

    /**
     * Ação: Remover palavras do dicionário
     *
     * @return void
     */
    private function removeWords()
    {
        $this->writeLine();
        $this->writeLine('Escreva abaixo as palavras a serem removidas.');
        $this->writeLine('Em seguida, digite o comando "--save" para salvar as alterações ou "--cancel" para cancelar.');

        $wordList = [];

        while(true)
        {
            $line = $this->read();

            if($line == '--save')
            {
                if(count($wordList) > 0)
                {
                    Database::deleteWords($wordList);

                    $this->writeLine();
                    $this->writeLine('Removido '.count($wordList).' palavra'.(count($wordList) > 1 ? 's' : '').' do dicionário.');
                    break;
                }
            }
            elseif($line == '--cancel')
            {
                $this->writeLine();
                $this->writeLine('Operação cancelada.');
                break;
            }
            else
            {
                $wordList[] = $line;
            }
        }

        $this->writeLine();
        $this->standBy();
    }

    /**
     * Ação: Consultar palavras no dicionário
     *
     * @return void
     */
    private function queryWords()
    {
        $this->writeLine();
        $this->writeLine('Escreva abaixo as palavras a serem consultadas.');
        $this->writeLine('Utilize o comando "--close" para fechar.');
        $this->writeLine();

        while(true)
        {
            $line = $this->read();

            if($line == '--close')
            {
                break;
            }
            else
            {
                $query = Database::queryWord($line);

                $this->writeLine();
                $this->writeLine('- Resultado: '.($query !== null ? $query : 'não encontrado'));
            }
        }

        $this->writeLine();
        $this->standBy();
    }

    /**
     * Ação: Listar todas as palavras do dicionário
     *
     * @return void
     */
    private function listWords()
    {
        $wordList = Database::allWords();
        $this->writeLine();

       if(count($wordList) > 0)
       {
           $this->writeLine('Abaixo todas as palavras atualmente no dicionário.');

           foreach($wordList as $word)
           {
               $this->writeLine('- '.$word);
           }
       }
        else
        {
            $this->writeLine('Nenhuma palavra no dicionário');
        }

        $this->writeLine();
        $this->standBy();
    }

    /**
     * Ação: Modo stand-by
     *
     * @throws \Exception
     * @throws \Symfony\Component\Console\Exception\ExceptionInterface
     */
    private function standBy()
    {
        $this->writeLine('Escolha uma das opções abaixo:');
        $this->writeLine();
        $this->writeLine('- add        Adicionar palavras.');
        $this->writeLine('- remove     Remover palavras.');
        $this->writeLine('- query      Consultar palavras.');
        $this->writeLine('- list       Listar palavras cadastradas.');
        $this->writeLine('- close      Fechar gerenciador e voltar ao menu principal.');
        $this->writeLine();

        switch($this->read())
        {
            case 'add' :
                $this->addWords();
                break;
            case 'remove' :
                $this->removeWords();
                break;
            case 'query' :
                $this->queryWords();
                break;
            case 'list' :
                $this->listWords();
                break;
            case 'close' :
                $this->writeLine();

                $command = $this->getApplication()->find('menu');
                $command->run($this->input, $this->output);
                break;
            default :
                $this->standBy();
                break;
        }
    }
}