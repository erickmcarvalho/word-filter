<?php
/**
 * Created by Érick Carvalho on 16/12/2015.
 */

namespace WordFilter;

use WordFilter\Support\Str;

/**
 * Trabalha em sugestões para correções de palavras.
 *
 * Class Correction
 * @package WordFilter
 */
class Correction
{
    /**
     * Palavra a ser corrigida
     *
     * @var string
     */
    private $word = '';

    /**
     * Tamanho da palavra
     *
     * @var int
     */
    private $length = 0;

    /**
     * Palavra-chave
     *
     * @var string
     */
    private $keyword = '';

    /**
     * Letras do alfabeto
     *
     * @var array
     */
    private $alphabet = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z'];

    /**
     * Inicia a instância
     *
     * @param $word
     */
    public function __construct($word)
    {
        $this->word = $word;
        $this->length = Str::length($word);
        $this->keyword = Str::lower(Str::withoutAccents($word));
    }

    /**
     * Retorna sugestões removendo letras da palavra-chave.
     *
     * @param bool|true $dictionary
     * @return array
     */
    public function caseRemove($dictionary = true)
    {
        if($this->length > 1)
        {
            if($this->length == 2)
            {
                return [
                    $this->keyword{0},
                    $this->keyword{1}
                ];
            }
            else
            {
                $suggestions = [];

                for($i = 0; $i < $this->length; $i++)
                {
                    $initialWord = trim(substr_replace($this->keyword, '', $i + 1, 1));
                    $finalWord = trim(substr_replace($this->keyword, '', -($i + 1), 1));

                    if($dictionary === true)
                    {
                        $initialSearch = trim(Dictionary::queryWord($initialWord));
                        $finalSearch = trim(Dictionary::queryWord($finalWord));

                        if(!empty($initialSearch))
                        {
                            $suggestions[] = $initialSearch;
                        }

                        if(!empty($finalSearch))
                        {
                            $suggestions[] = $finalSearch;
                        }
                    }
                    else
                    {
                        $suggestions[] = $initialWord;
                        $suggestions[] = $finalWord;
                    }
                }

                return array_filter($suggestions);
            }
        }

        return [$this->word];
    }

    /**
     * Gera sugestões adicionando letras a palavra-chave.
     *
     * @param bool|true $dictionary
     * @return array
     */
    public function caseAdd($dictionary = true)
    {
        $suggestions = [];

        for($i = 0; $i < $this->length; $i++)
        {
            foreach($this->alphabet as $letter)
            {
                $word = '';

                for($t = 0; $t <= $i; $t++)
                {
                    $word .= $this->keyword{$t};
                }

                $word = trim($word.$letter.substr($this->keyword, $i + 1));

                if($dictionary === true)
                {
                    $search = trim(Dictionary::queryWord($word));

                    if(!empty($search))
                    {
                        $suggestions[] = $search;
                    }
                }
                elseif(!empty($word))
                {
                    $suggestions[] = $word;
                }
            }
        }

        foreach($this->alphabet as $letter)
        {
            $word = trim($letter.$this->keyword);

            if($dictionary === true)
            {
                $search = trim(Dictionary::queryWord($word));

                if(!empty($search))
                {
                    $suggestions[] = $search;
                }
            }
            elseif(!empty($word))
            {
                $suggestions[] = $word;
            }
        }

        return array_filter($suggestions);
    }

    /**
     * Gera sugestões alterando letras na palavra-chave.
     *
     * @param bool|true $dictionary
     * @return array
     */
    public function casePop($dictionary = true)
    {
        $suggestions = [];

        for($i = 0; $i < $this->length; $i++)
        {
            foreach($this->alphabet as $letter)
            {
                $word = trim(substr_replace($this->keyword, $letter, $i, 1));

                if($dictionary === true)
                {
                    $search = trim(Dictionary::queryWord($word));

                    if(!empty($search))
                    {
                        $suggestions[] = $search;
                    }
                }
                elseif(!empty($word))
                {
                    $suggestions[] = $word;
                }
            }
        }

        return array_filter($suggestions);
    }
}