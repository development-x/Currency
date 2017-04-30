<?php

class CurrencyConverter
{

    private static $translations = array(
        # numbers
        0 => 'нула',
        1 => 'един',
        2 => 'два',
        3 => 'три',
        4 => 'четири',
        5 => 'пет',
        6 => 'шест',
        7 => 'седем',
        8 => 'осем',
        9 => 'девет',
        10 => 'десет',
        11 => 'единадесет',
        12 => 'дванадесет',
        13 => 'тринадесет',
        14 => 'четиринадесет',
        15 => 'петнадесет',
        16 => 'шестнадесет',
        17 => 'седемнадесет',
        18 => 'осемнадесет',
        19 => 'деветнадесет',
        20 => 'двадесет',
        30 => 'тридесет',
        40 => 'четиридесет',
        50 => 'петдесет',
        60 => 'шестдесет',
        70 => 'седемдесет',
        80 => 'осемдесет',
        90 => 'деветдесет',
        100 => 'сто',
        200 => 'двеста',
        300 => 'триста',
        1000 => 'хиляда',
        # prefixes
        'tens' => 'десет',
        'hundreds' => 'стотин',
        'thousands' => 'хиляди',
        'million' => 'милион',
        'millions' => 'милиона',
        # amounts
        'amount' => 'лев',
        'amounts' => 'лева',
        'cent' => 'стотинка',
        'cents' => 'стотинки',
        # others
        'and' => ' и ',
    );

    /**
     * 
     * @param float $amount
     * @param array|null $translations
     * 
     * @return string
     * 
     * @throws Exception
     */
    public static function convertToText($amount, $translations = array(), $lang = 'bg')
    {

        $t = array_replace(self::$translations, $translations);

        list($sum, $cents) = array_map(function($value) {
            settype($value, 'int');
            return $value;
        }, explode('.', $amount));

        $results = array(
            self::normalize($sum, $t, $lang),
            $sum == 1 ? $t['amount'] : $t['amounts']
        );

        if ($cents !== 0) {
            $results[] = trim($t['and']);
            $results[] = self::normalize($cents, $t, $lang);
            $results[] = $cents == 1 ? $t['cent'] : $t['cents'];
        }

        return self::standartize(implode(' ', $results));
    }

    public static function normalize($value, $t, $lang = 'bg')
    {

        switch (true) {
            case $value === 0 :
                return "";
            case isset($t[$value]) :
                return $t[$value];
            case $value < 100 :
                $module = $value % 10;
                $division = floor($value / 10);
                if ($lang === 'bg') {
                    return $t[$division] . $t['tens'] . $t['and'] . $t[$module];
                } else {
                    return $t[$value - $module] . '-' . $t[$module];
                }
            case $value < 1000 :
                $module = $value % 100;
                $division = floor($value / 100);
                $and = $module <= 20 || $module % 10 === 0 ? $t['and'] : ' ';
                if ($lang === 'bg') {
                    return (isset($t[$value - $module]) ? $t[$value - $module] : $t[$division] . $t['hundreds']) . $and . self::normalize($module, $t, $lang);
                } else {
                    return $t[$division] . ' ' . $t['hundreds'] . $and . self::normalize($module, $t, $lang);
                }
            case $value < 1000000 :
                $module = $value % 1000;
                $division = $value / 1000;
                return self::normalize($division, $t) . ' ' . $t['thousands'] . ' ' . self::normalize($module, $t, $lang);
            case $value < 1000000000 :
                $module = $value % 1000000;
                $division = $value / 1000000;
                $millions = floor($value / 1000000);
                return self::normalize($division, $t) . ' ' . ($millions == 1 ? $t['million'] : $t['millions']) . ' ' . self::normalize($module, $t, $lang);
            default :
                throw new Exception("$value is greeater than 1000000000");
        }
    }
    
    /**
     * 
     * @param string $value
     * 
     * @return string
     */
    public static function standartize($value)
    {
        $original = array('един стотинка', 'два стотинки');
        $translatable = array('една стотинка', 'две стотинки');
        return str_replace($original, $translatable, $value);
    }

}
