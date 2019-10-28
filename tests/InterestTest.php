<?php

namespace App\Tests;

use PHPUnit\Framework\TestCase;
use App\Util\InterestCalculator;

class InterestTest extends TestCase
{
    public function testCalculateInterest()
    {
        $calculator = new InterestCalculator();
        $result = $calculator->calculateInterest(10000);

        // assert that your calculator added the numbers correctly!
        $this->assertEquals(1, $result);
    }
}
