<?php
/**
 * Created by Érick Carvalho on 17/12/2015.
 */

namespace WordFilter\Console;

use Symfony\Component\Console\Command\Command as SymfonyCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use WordFilter\Support\Str;

/**
 * Classe abstrata para configuração dos comandos no console.
 *
 * Class Command
 * @package WordFilter\Console
 */
abstract class Command extends SymfonyCommand
{
    /**
     * Interface de input
     *
     * @var InputInterface
     */
    protected $input;

    /**
     * Interface de output
     *
     * @var OutputInterface
     */
    protected $output;

    /**
     * Execução do comando
     *
     * @param \Symfony\Component\Console\Input\InputInterface   $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->input = $input;
        $this->output = $output;

        $this->handle();
    }

    /**
     * Ler linha de input
     *
     * @return string
     */
    protected function read()
    {
        $helper = $this->getHelper('question');
        $question = new Question('> ');

        return $helper->ask($this->input, $this->output, $question);
    }

    /**
     * Escrever na tela
     *
     * @param string     $messages
     * @param bool|false $newLine
     * @param int        $options
     * @return void
     */
    protected function write($messages = '', $newLine = false, $options = 0)
    {
        if(is_array($messages))
        {
            array_walk($messages, function(&$item)
            {
                return Str::accents($item);
            });
        }
        else
        {
            $messages = Str::accents($messages);
        }

        $this->output->write($messages, $newLine, $options);
    }

    /**
     * Escrever linha na tela
     *
     * @param string $messages
     * @param int    $options
     * @return mixed
     */
    protected function writeLine($messages = '', $options = 0)
    {
        if(is_array($messages))
        {
            array_walk($messages, function(&$item)
            {
                return Str::accents($item);
            });
        }
        else
        {
            $messages = Str::accents($messages);
        }

        return $this->output->writeln($messages, $options);
    }

    /**
     * Handler de execução do comando
     *
     * @abstract
     * @return void
     */
    protected abstract function handle();
}