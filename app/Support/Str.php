<?php
/**
 * Created by Érick Carvalho on 16/12/2015.
 */

namespace WordFilter\Support;

/**
 * Helper para manipulação de strings.
 *
 * Class Str
 * @package WordFilter\Support
 */
class Str
{
    /**
     * Retorna o tamanho da string
     *
     * @param string $string
     * @return int
     */
    public static function length($string)
    {
        return mb_strlen($string, 'UTF-8');
    }

    /**
     * Retorna a string maiúscula
     *
     * @param string $string
     * @return string
     */
    public static function upper($string)
    {
        return mb_strtoupper($string, 'UTF-8');
    }

    /**
     * Retorna a string minúscula
     *
     * @param string $string
     * @return string
     */
    public static function lower($string)
    {
        return mb_strtolower($string, 'UTF-8');
    }

    /**
     * Verifica se a string está em UTF8
     *
     * @param $string
     * @return bool
     */
    public static function isUtf8($string)
    {
        $length = strlen($string);

        for($i = 0; $i < $length; $i++)
        {
            $ascii = ord($string{$i});

            if($ascii > 128)
            {
                if($ascii >= 254)
                    return false;
                elseif($ascii >= 252)
                    $bits = 6;
                elseif($ascii >= 248)
                    $bits = 5;
                elseif($ascii >= 240)
                    $bits = 4;
                elseif($ascii >= 224)
                    $bits = 3;
                elseif($ascii >= 192)
                    $bits = 2;
                else return false;

                if(($i + $bits) > $length)
                    return false;

                while($bits > 1)
                {
                    $i++;
                    $ascii = ord($string{$i});

                    if($ascii < 128 || $ascii > 191)
                        return false;

                    $bits--;
                }
            }
        }
        return true;
    }

    /**
     * Corrige os acentos
     *
     * @param string $string
     * @return string
     */
    public static function accents($string)
    {
        if(strtoupper(substr(PHP_OS, 0, 3)) === "WIN")
        {
            return strtr($string, [
                'À' => chr(65),
                'Á' => chr(65),
                'Â' => chr(65),
                'Ã' => chr(65),
                'Ä' => chr(142),
                'Å' => chr(143),
                'Ç' => chr(128),
                'È' => chr(69),
                'É' => chr(144),
                'Ê' => chr(69),
                'Ë' => chr(69),
                'Ì' => chr(73),
                'Í' => chr(73),
                'Î' => chr(73),
                'Ï' => chr(73),
                'Ò' => chr(79),
                'Ó' => chr(79),
                'Ô' => chr(79),
                'Õ' => chr(79),
                'Ö' => chr(153),
                'Ù' => chr(85),
                'Ú' => chr(85),
                'Û' => chr(85),
                'Ü' => chr(154),
                'à' => chr(133),
                'á' => chr(160),
                'â' => chr(131),
                'ã' => chr(97),
                'ä' => chr(132),
                'å' => chr(134),
                'ç' => chr(135),
                'è' => chr(138),
                'é' => chr(130),
                'ê' => chr(136),
                'ë' => chr(101),
                'ì' => chr(141),
                'í' => chr(161),
                'î' => chr(140),
                'ï' => chr(139),
                'ò' => chr(149),
                'ó' => chr(162),
                'ô' => chr(147),
                'õ' => chr(111),
                'ö' => chr(148),
                'ù' => chr(151),
                'ú' => chr(163),
                'û' => chr(150),
                'ü' => chr(129)
            ]);
        }
        else
        {
            return mb_convert_encoding($string, 'UTF-8');
        }
    }

    /**
     * Remove os acentos
     *
     * @param    string $string - A string de entrada
     * @return   string
     */
    public static function withoutAccents($string)
    {
        if(!preg_match("/[\x80-\xff]/", $string))
        {
            return $string;
        }

        $string = strtr($string, [
            chr(65) => 'A',
            chr(65) => 'A',
            chr(65) => 'A',
            chr(65) => 'A',
            chr(142) => 'A',
            chr(143) => 'A',
            chr(128) => 'C',
            chr(69) => 'E',
            chr(144) => 'E',
            chr(69) => 'E',
            chr(69) => 'E',
            chr(73) => 'I',
            chr(73) => 'I',
            chr(73) => 'I',
            chr(73) => 'I',
            chr(79) => 'O',
            chr(79) => 'O',
            chr(79) => 'O',
            chr(79) => 'O',
            chr(153) => 'O',
            chr(85) => 'U',
            chr(85) => 'U',
            chr(85) => 'U',
            chr(154) => 'U',
            chr(133) => 'a',
            chr(160) => 'a',
            chr(131) => 'a',
            chr(97) => 'a',
            chr(132) => 'a',
            chr(134) => 'a',
            chr(135) => 'c',
            chr(138) => 'e',
            chr(130) => 'e',
            chr(136) => 'e',
            chr(101) => 'e',
            chr(141) => 'i',
            chr(161) => 'i',
            chr(140) => 'i',
            chr(139) => 'i',
            chr(149) => 'o',
            chr(162) => 'o',
            chr(147) => 'o',
            chr(111) => 'o',
            chr(148) => 'o',
            chr(151) => 'u',
            chr(163) => 'u',
            chr(150) => 'u',
            chr(129) => 'u',
        ]);

        if(static::isUtf8($string))
        {
            $_chr = [
                /* Latin-1 Supplement */
                chr(195).chr(128) => 'A',
                chr(195).chr(129) => 'A',
                chr(195).chr(130) => 'A',
                chr(195).chr(131) => 'A',
                chr(195).chr(132) => 'A',
                chr(195).chr(133) => 'A',
                chr(195).chr(135) => 'C',
                chr(195).chr(136) => 'E',
                chr(195).chr(137) => 'E',
                chr(195).chr(138) => 'E',
                chr(195).chr(139) => 'E',
                chr(195).chr(140) => 'I',
                chr(195).chr(141) => 'I',
                chr(195).chr(142) => 'I',
                chr(195).chr(143) => 'I',
                chr(195).chr(145) => 'N',
                chr(195).chr(146) => 'O',
                chr(195).chr(147) => 'O',
                chr(195).chr(148) => 'O',
                chr(195).chr(149) => 'O',
                chr(195).chr(150) => 'O',
                chr(195).chr(153) => 'U',
                chr(195).chr(154) => 'U',
                chr(195).chr(155) => 'U',
                chr(195).chr(156) => 'U',
                chr(195).chr(157) => 'Y',
                chr(195).chr(159) => 's',
                chr(195).chr(160) => 'a',
                chr(195).chr(161) => 'a',
                chr(195).chr(162) => 'a',
                chr(195).chr(163) => 'a',
                chr(195).chr(164) => 'a',
                chr(195).chr(165) => 'a',
                chr(195).chr(167) => 'c',
                chr(195).chr(168) => 'e',
                chr(195).chr(169) => 'e',
                chr(195).chr(170) => 'e',
                chr(195).chr(171) => 'e',
                chr(195).chr(172) => 'i',
                chr(195).chr(173) => 'i',
                chr(195).chr(174) => 'i',
                chr(195).chr(175) => 'i',
                chr(195).chr(177) => 'n',
                chr(195).chr(178) => 'o',
                chr(195).chr(179) => 'o',
                chr(195).chr(180) => 'o',
                chr(195).chr(181) => 'o',
                chr(195).chr(182) => 'o',
                chr(195).chr(182) => 'o',
                chr(195).chr(185) => 'u',
                chr(195).chr(186) => 'u',
                chr(195).chr(187) => 'u',
                chr(195).chr(188) => 'u',
                chr(195).chr(189) => 'y',
                chr(195).chr(191) => 'y',
                /* Latin Extended-A */
                chr(196).chr(128) => 'A',
                chr(196).chr(129) => 'a',
                chr(196).chr(130) => 'A',
                chr(196).chr(131) => 'a',
                chr(196).chr(132) => 'A',
                chr(196).chr(133) => 'a',
                chr(196).chr(134) => 'C',
                chr(196).chr(135) => 'c',
                chr(196).chr(136) => 'C',
                chr(196).chr(137) => 'c',
                chr(196).chr(138) => 'C',
                chr(196).chr(139) => 'c',
                chr(196).chr(140) => 'C',
                chr(196).chr(141) => 'c',
                chr(196).chr(142) => 'D',
                chr(196).chr(143) => 'd',
                chr(196).chr(144) => 'D',
                chr(196).chr(145) => 'd',
                chr(196).chr(146) => 'E',
                chr(196).chr(147) => 'e',
                chr(196).chr(148) => 'E',
                chr(196).chr(149) => 'e',
                chr(196).chr(150) => 'E',
                chr(196).chr(151) => 'e',
                chr(196).chr(152) => 'E',
                chr(196).chr(153) => 'e',
                chr(196).chr(154) => 'E',
                chr(196).chr(155) => 'e',
                chr(196).chr(156) => 'G',
                chr(196).chr(157) => 'g',
                chr(196).chr(158) => 'G',
                chr(196).chr(159) => 'g',
                chr(196).chr(160) => 'G',
                chr(196).chr(161) => 'g',
                chr(196).chr(162) => 'G',
                chr(196).chr(163) => 'g',
                chr(196).chr(164) => 'H',
                chr(196).chr(165) => 'h',
                chr(196).chr(166) => 'H',
                chr(196).chr(167) => 'h',
                chr(196).chr(168) => 'I',
                chr(196).chr(169) => 'i',
                chr(196).chr(170) => 'I',
                chr(196).chr(171) => 'i',
                chr(196).chr(172) => 'I',
                chr(196).chr(173) => 'i',
                chr(196).chr(174) => 'I',
                chr(196).chr(175) => 'i',
                chr(196).chr(176) => 'I',
                chr(196).chr(177) => 'i',
                chr(196).chr(178) => 'IJ',
                chr(196).chr(179) => 'ij',
                chr(196).chr(180) => 'J',
                chr(196).chr(181) => 'j',
                chr(196).chr(182) => 'K',
                chr(196).chr(183) => 'k',
                chr(196).chr(184) => 'k',
                chr(196).chr(185) => 'L',
                chr(196).chr(186) => 'l',
                chr(196).chr(187) => 'L',
                chr(196).chr(188) => 'l',
                chr(196).chr(189) => 'L',
                chr(196).chr(190) => 'l',
                chr(196).chr(191) => 'L',
                chr(197).chr(128) => 'l',
                chr(197).chr(129) => 'L',
                chr(197).chr(130) => 'l',
                chr(197).chr(131) => 'N',
                chr(197).chr(132) => 'n',
                chr(197).chr(133) => 'N',
                chr(197).chr(134) => 'n',
                chr(197).chr(135) => 'N',
                chr(197).chr(136) => 'n',
                chr(197).chr(137) => 'N',
                chr(197).chr(138) => 'n',
                chr(197).chr(139) => 'N',
                chr(197).chr(140) => 'O',
                chr(197).chr(141) => 'o',
                chr(197).chr(142) => 'O',
                chr(197).chr(143) => 'o',
                chr(197).chr(144) => 'O',
                chr(197).chr(145) => 'o',
                chr(197).chr(146) => 'OE',
                chr(197).chr(147) => 'oe',
                chr(197).chr(148) => 'R',
                chr(197).chr(149) => 'r',
                chr(197).chr(150) => 'R',
                chr(197).chr(151) => 'r',
                chr(197).chr(152) => 'R',
                chr(197).chr(153) => 'r',
                chr(197).chr(154) => 'S',
                chr(197).chr(155) => 's',
                chr(197).chr(156) => 'S',
                chr(197).chr(157) => 's',
                chr(197).chr(158) => 'S',
                chr(197).chr(159) => 's',
                chr(197).chr(160) => 'S',
                chr(197).chr(161) => 's',
                chr(197).chr(162) => 'T',
                chr(197).chr(163) => 't',
                chr(197).chr(164) => 'T',
                chr(197).chr(165) => 't',
                chr(197).chr(166) => 'T',
                chr(197).chr(167) => 't',
                chr(197).chr(168) => 'U',
                chr(197).chr(169) => 'u',
                chr(197).chr(170) => 'U',
                chr(197).chr(171) => 'u',
                chr(197).chr(172) => 'U',
                chr(197).chr(173) => 'u',
                chr(197).chr(174) => 'U',
                chr(197).chr(175) => 'u',
                chr(197).chr(176) => 'U',
                chr(197).chr(177) => 'u',
                chr(197).chr(178) => 'U',
                chr(197).chr(179) => 'u',
                chr(197).chr(180) => 'W',
                chr(197).chr(181) => 'w',
                chr(197).chr(182) => 'Y',
                chr(197).chr(183) => 'y',
                chr(197).chr(184) => 'Y',
                chr(197).chr(185) => 'Z',
                chr(197).chr(186) => 'z',
                chr(197).chr(187) => 'Z',
                chr(197).chr(188) => 'z',
                chr(197).chr(189) => 'Z',
                chr(197).chr(190) => 'z',
                chr(197).chr(191) => 's',
                /* Euro Sign */
                chr(226).chr(130).chr(172) => 'E',
                /* GBP (Pound) Sign */
                chr(194).chr(163) => ''
            ];

            $string = strtr($string, $_chr);
        }
        else
        {
            $_chr = [];
            $_dblChars = [];

            /* We assume ISO-8859-1 if not UTF-8 */
            $_chr['in'] = chr(128).chr(131).chr(138).chr(142).chr(154).chr(158).chr(159).chr(162).chr(165).chr(181).chr(192).chr(193).chr(194).chr(195).chr(199).chr(200).chr(201).chr(202).chr(203).chr(204).chr(205).chr(206).chr(207).chr(209).chr(210).chr(211).chr(212).chr(213).chr(217).chr(218).chr(219).chr(220).chr(221).chr(224).chr(225).chr(226).chr(227).chr(231).chr(232).chr(233).chr(234).chr(235).chr(236).chr(237).chr(238).chr(239).chr(241).chr(242).chr(243).chr(244).chr(245).chr(249).chr(250).chr(251).chr(252).chr(253).chr(255).chr(191).chr(182).chr(179).chr(166).chr(230).chr(198).chr(175).chr(172).chr(188).chr(163).chr(161).chr(177);

            $_chr['out'] = "EfSZszYcYuAAAACEEEEIIIINOOOOUUUUYaaaaceeeeiiiinoooouuuuyyzslScCZZzLAa";

            $string = strtr($string, $_chr['in'], $_chr['out']);
            $_dblChars['in'] = [
                chr(140),
                chr(156),
                chr(196),
                chr(197),
                chr(198),
                chr(208),
                chr(214),
                chr(216),
                chr(222),
                chr(223),
                chr(228),
                chr(229),
                chr(230),
                chr(240),
                chr(246),
                chr(248),
                chr(254)
            ];

            $_dblChars['out'] = [
                'Oe',
                'oe',
                'Ae',
                'Aa',
                'Ae',
                'DH',
                'Oe',
                'Oe',
                'TH',
                'ss',
                'ae',
                'aa',
                'ae',
                'dh',
                'oe',
                'oe',
                'th'
            ];

            $string = str_replace($_dblChars['in'], $_dblChars['out'], $string);
        }

        return $string;
    }
}