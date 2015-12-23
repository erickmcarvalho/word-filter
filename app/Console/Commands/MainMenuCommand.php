<?php
/**
 * Created by Érick Carvalho on 17/12/2015.
 */

namespace WordFilter\Console\Commands;

use WordFilter\Console\Command;

/**
 * Comando do menu principal do programa.
 *
 * Class MainMenuCommand
 * @package WordFilter\Console\Commands
 */
class MainMenuCommand extends Command
{
    /**
     * Configura o comando
     *
     * @return void
     */
    protected function configure()
    {
        $this->setName('menu')->setDescription('Menu principal.');
    }

    /**
     * Executa o comando
     *
     * @return void
     */
    protected function handle()
    {
        $this->writeLine('=======================================================');
        $this->writeLine('Seja bem vindo ao "Word Filter".');
        $this->writeLine('Por: Érick Carvalho.');
        $this->writeLine('Este software tem como objetivo sugerir correções para erros de digitação.');
        $this->standBy();
    }

    /**
     * Ação: Modo stand-by
     *
     * @throws \Exception
     * @throws \Symfony\Component\Console\Exception\ExceptionInterface
     */
    public function standBy()
    {
        $this->writeLine('=======================================================');
        $this->writeLine('Menu principal');
        $this->writeLine('Selecione uma das opções abaixo:');
        $this->writeLine();
        $this->writeLine('- dictionary  Abre o gerenciador do dicionário.');
        $this->writeLine('- corrector   Abre o corretor de palavras.');
        $this->writeLine('- info        Informações sobre o software.');
        $this->writeLine('- exit        Fecha o programa.');
        $this->writeLine();

        switch($this->read())
        {
            case 'dictionary' :
                $command = $this->getApplication()->find('dictionary');
                $command->run($this->input, $this->output);
                break;
            case 'corrector' :
                $command = $this->getApplication()->find('corrector');
                $command->run($this->input, $this->output);
                break;
            case 'info' :
            case 'version' :
                $this->writeLine('Word Filter '.$this->getApplication()->getVersion());
                $this->writeLine('Powered by Érick Anthony de Oliveira Carvalho');
                $this->standBy();
                break;
            case 'exit' :
            case 'close' :
            case 'logout' :
                $this->writeLine('Fechado o programa...');
                $this->writeLine('Good bye! =)');
                die;
                break;
            default :
                $this->standBy();
                break;
        }
    }
}