<?php
/**
 * Created by PhpStorm.
 * User: niki
 * Date: 10/28/19
 * Time: 8:46 PM
 */

namespace App\Util;

class InterestCalculator
{

    public function calculateInterest($amount)
    {
        return ($amount * 0.01) / 100;
    }

}