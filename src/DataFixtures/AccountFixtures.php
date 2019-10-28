<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Account;

class AccountFixtures extends Fixture
{

    public function load(ObjectManager $manager)
    {
        //generate current date
        $date = new \DateTime();
        $date->setTimestamp(time());

        $acc = new Account();
        $acc->setTotal(333);
        $acc->setClientId(66);
        $acc->setAvailable(1);
        $acc->setUpdatedAt($date);
        $manager->persist($acc);

        $acc = new Account();
        $acc->setTotal(999);
        $acc->setClientId(66);
        $acc->setAvailable(1);
        $acc->setUpdatedAt($date);
        $manager->persist($acc);

        $acc = new Account();
        $acc->setTotal(222);
        $acc->setClientId(55);
        $acc->setAvailable(1);
        $acc->setUpdatedAt($date);
        $manager->persist($acc);

        $acc = new Account();
        $acc->setTotal(502);
        $acc->setClientId(55);
        $acc->setAvailable(1);
        $acc->setUpdatedAt($date);
        $manager->persist($acc);

        $manager->flush();
    }
}
