<?php

class Currency
{

    const LANG_BG = 'bg';
    const LANG_EN = 'en';

    /**
     *
     * @var string
     */
    private static $lang;
    
    /**
     *
     * @var array
     */
    private static $trans;

    /**
     * 
     * @param int $amount
     * @param string $lang
     * 
     * @return string
     * 
     * @throws Exception
     */
    public static function convertToText($amount, $lang = self::LANG_BG)
    {

        self::$lang = $lang;

        if (null === self::$trans) {
            self::$trans = parse_ini_file(__DIR__ . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'lang.ini', true);
        }

        if (!isset(self::$trans[self::$lang])) {
            throw new InvalidArgumentException('Invalid lang specified');
        }
        
        if (strchr($amount, '.')) {
            list($sum, $cents) = array_map(function($value) {
                settype($value, 'int');
                return $value;
            }, explode('.', $amount));
        } else {
            $sum = intval($amount);
            $cents = 00;
        }

        $results = array(
            self::normalize($sum),
            $sum == 1 ? self::$trans[self::$lang]['amount'] : self::$trans[self::$lang]['amounts']
        );

        if ($cents !== 0) {
            $results[] = trim(self::$trans[self::$lang]['and']);
            $results[] = self::normalize($cents);
            $results[] = $cents == 1 ? self::$trans[self::$lang]['cent'] : self::$trans[self::$lang]['cents'];
        }

        return self::standartize(implode(' ', $results));
    }

    /**
     * 
     * @param int $value
     * 
     * @return string
     * 
     * @throws Exception
     */
    public static function normalize($value)
    {

        switch (true) {
            case $value === 0 :
                return "";
            case isset(self::$trans[self::$lang][$value]) :
                return self::$trans[self::$lang][$value];
            case $value < 100 :
                $module = $value % 10;
                $division = floor($value / 10);
                if (self::LANG_BG === self::$lang) {
                    if (isset(self::$trans[self::$lang][$value])) {
                        return self::$trans[self::$lang][$value];
                    } else {
                        return self::$trans[self::$lang][$division] . self::$trans[self::$lang]['tens'] . self::$trans[self::$lang]['and'] . self::$trans[self::$lang][$module];
                    }
                } else {
                    return self::$trans[self::$lang][$value - $module] . '-' . self::$trans[self::$lang][$module];
                }
            case $value < 1000 :
                $module = $value % 100;
                $division = floor($value / 100);
                $and = $module <= 20 || $module % 10 === 0 ? self::$trans[self::$lang]['and'] : ' ';
                if (self::LANG_BG === self::$lang) {
                    return (isset(self::$trans[self::$lang][$value - $module]) ? self::$trans[self::$lang][$value - $module] : self::$trans[self::$lang][$division] . self::$trans[self::$lang]['hundreds']) . $and . self::normalize($module);
                } else {
                    return self::$trans[self::$lang][$division] . ' ' . self::$trans[self::$lang]['hundreds'] . $and . self::normalize($module);
                }
            case $value < 1000000 :
                $module = $value % 1000;
                $division = $value / 1000;
                return self::normalize($division) . ' ' . self::$trans[self::$lang]['thousands'] . ' ' . self::normalize($module);
            case $value < 1000000000 :
                $module = $value % 1000000;
                $division = $value / 1000000;
                $millions = floor($value / 1000000);
                return self::normalize($division) . ' ' . ($millions == 1 ? self::$trans[self::$lang]['million'] : self::$trans[self::$lang]['millions']) . ' ' . self::normalize($module);
            default :
                throw new InvalidArgumentException("$value is greeater than 1000000000");
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
        $standartize = array('една стотинка', 'две стотинки');
        return str_replace($original, $standartize, $value);
    }

}
