<?php
/**
 * Created by Érick Carvalho on 16/12/2015.
 */

namespace WordFilter;

use SQLite3;
use WordFilter\Support\File;
use WordFilter\Support\Str;

/**
 * Dicionário de palavras.
 *
 * Class Dictionary
 * @package WordFilter
 */
class Dictionary
{
    /**
     * Conexão com SQLite
     *
     * @var \SQLite3
     */
    private static $connection = null;

    /**
     * SQLite3 encryption key
     */
    const DB_CRYPT_KEY = "F10s`'7*Ep4e>mg";

    /**
     * Testar conexão
     */
    public static function testConnection()
    {
        return static::connection() == true;
    }

    /**
     * Retorna todas as palavras disponíveis do dicionário
     *
     * @return array
     */
    public static function allWords()
    {
        $list = [];

        $query = static::connection()->query('SELECT Word FROM WordDictionary ORDER BY Word ASC');

        while($fetch = $query->fetchArray())
        {
            $list[] = trim($fetch['Word']);
        }

        return $list;
    }

    /**
     * Consultar uma palavra
     *
     * @param string $word
     * @return string|null
     */
    public static function queryWord($word)
    {
        $stmt = static::connection()->prepare('SELECT Word FROM WordDictionary WHERE Keyword = :keyword');
        $stmt->bindValue(':keyword', Str::lower(Str::withoutAccents($word)), SQLITE3_TEXT);

        $query = $stmt->execute();
        $fetch = $query->fetchArray();

        return count($fetch) > 0 ? $fetch['Word'] : null;
    }

    /**
     * Adicionar palavra
     *
     * @param string|array $word
     * @return void
     */
    public static function addWords($word)
    {
        if(is_array($word))
        {
            $query = '';

            foreach($word as $value)
            {
                $wordScape = static::connection()->escapeString($value);
                $keywordScape = static::connection()->escapeString(Str::lower(Str::withoutAccents($value)));

                if(static::queryWord($value) === null)
                {
                    $query .= "INSERT INTO WordDictionary (Word, Keyword) VALUES ('".$wordScape."', '".$keywordScape."');\n";
                }
            }

            static::connection()->exec($query);
        }
        else
        {
            if(static::queryWord($word) === null)
            {
                $stmt = static::connection()->prepare('INSERT INTO WordDictionary (Word, Keyword) VALUES (?, ?)');
                $stmt->bindValue(1, $word, SQLITE3_TEXT);
                $stmt->bindValue(2, Str::lower(Str::withoutAccents($word)), SQLITE3_TEXT);
                $stmt->execute();
            }
        }
    }

    /**
     * Remover palavra
     *
     * @param string|array $word
     * @return void
     */
    public static function deleteWords($word)
    {
        if(is_array($word))
        {
            $query = '';

            foreach($word as $value)
            {
                $query .= "DELETE FROM WordDictionary WHERE Keyword = '".static::connection()->escapeString(Str::lower(Str::withoutAccents($value)))."';\n";
            }

            static::connection()->exec($query);
        }
        else
        {
            $stmt = static::connection()->prepare('DELETE FROM WordDictionary WHERE Keyword = ?');
            $stmt->bindValue(1, Str::lower(Str::withoutAccents($word)), SQLITE3_TEXT);
            $stmt->execute();
        }
    }

    /**
     * Retorna a conexão
     *
     * @return \SQLite3
     */
    private static function connection()
    {
        if(static::$connection === null)
        {
            static::$connection = new SQLite3(File::path('storage/database.sqlite'), SQLITE3_OPEN_READWRITE | SQLITE3_OPEN_CREATE, static::DB_CRYPT_KEY);

            if(filesize(File::path('storage/database.sqlite')) < 1)
            {
                static::schemaBuild();
            }
        }

        return static::$connection;
    }

    /**
     * Cria o banco de dados
     *
     * @return void
     */
    private static function schemaBuild()
    {
        static::connection()->exec("
            CREATE TABLE WordDictionary
            (
              Id INTEGER PRIMARY KEY AUTOINCREMENT,
              Word VARCHAR(20) NOT NULL,
              Keyword VARCHAR(20) NOT NULL
            )
        ");
    }
}