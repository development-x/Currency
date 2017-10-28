<?php

class CurrencyTest extends \PHPUnit_Framework_TestCase
{

    public function testValidCurrencyAmounts()
    {

        $amounts = array(
            '309.89' => array('bg' => 'триста и девет лева и осемдесет и девет стотинки', 'en' => 'three hundred and nine euros and eighty-nine cents'),
            '163.20' => array('bg' => 'сто шестдесет и три лева и двадесет стотинки', 'en' => 'one hundred sixty-three euros and twenty cents'),
            '401.32' => array('bg' => 'четиристотин и един лева и тридесет и две стотинки', 'en' => 'four hundred and one euros and thirty-two cents'),
            '289.27' => array('bg' => 'двеста осемдесет и девет лева и двадесет и седем стотинки', 'en' => 'two hundred eighty-nine euros and twenty-seven cents'),
            '977.29' => array('bg' => 'деветстотин седемдесет и седем лева и двадесет и девет стотинки', 'en' => 'nine hundred seventy-seven euros and twenty-nine cents'),
            '772.56' => array('bg' => 'седемстотин седемдесет и два лева и петдесет и шест стотинки', 'en' => 'seven hundred seventy-two euros and fifty-six cents'),
            '319.20' => array('bg' => 'триста и деветнадесет лева и двадесет стотинки', 'en' => 'three hundred and nineteen euros and twenty cents'),
            '571.40' => array('bg' => 'петстотин седемдесет и един лева и четиридесет стотинки', 'en' => 'five hundred seventy-one euros and forty cents'),
            '765.23' => array('bg' => 'седемстотин шестдесет и пет лева и двадесет и три стотинки', 'en' => 'seven hundred sixty-five euros and twenty-three cents'),
            '896.17' => array('bg' => 'осемстотин деветдесет и шест лева и седемнадесет стотинки', 'en' => 'eight hundred ninety-six euros and seventeen cents'),
            '596.15' => array('bg' => 'петстотин деветдесет и шест лева и петнадесет стотинки', 'en' => 'five hundred ninety-six euros and fifteen cents'),
            '705.92' => array('bg' => 'седемстотин и пет лева и деветдесет и две стотинки', 'en' => 'seven hundred and five euros and ninety-two cents'),
            '348.48' => array('bg' => 'триста четиридесет и осем лева и четиридесет и осем стотинки', 'en' => 'three hundred forty-eight euros and forty-eight cents'),
        );

        foreach ($amounts AS $amount => $translation) {
            $this->assertEquals($translation['bg'], Currency::convertToText($amount, Currency::LANG_BG));
            $this->assertEquals($translation['en'], Currency::convertToText($amount, Currency::LANG_EN));
        }
    }
    
    public function testCurrencyException()
    {
        $this->setExpectedException('\InvalidArgumentException');
        Currency::convertToText(1.03, 'es');
    }

}
