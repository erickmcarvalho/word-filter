<?php
/**
 * Created by Érick Carvalho on 16/12/2015.
 */

namespace WordFilter\Support;

/**
 * Helper para manipulação de arquivos.
 *
 * Class File
 * @package WordFilter\Support
 */
class File
{
    /**
     * Retorna o caminho real da aplicação
     *
     * @param string $path
     * @return string
     */
    public static function path($path = '')
    {
        return realpath(__DIR__.'/../../'.$path);
    }

    /**
     * Verifica se o arquivo existe
     *
     * @param string $path
     * @return bool
     */
    public static function exists($path = '')
    {
        return file_exists(static::path($path)) == true;
    }
}