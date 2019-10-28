<?php

namespace App\DataFixtures;

use App\Entity\Client;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class ClientFixture extends Fixture
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $client = new Client();
        $client->setId(55);

        //set id metadata
        $metadata = $manager->getClassMetadata(get_class($client));
        $metadata->setIdGenerator(new \Doctrine\ORM\Id\AssignedGenerator());
        $metadata->setIdGeneratorType(\Doctrine\ORM\Mapping\ClassMetadata::GENERATOR_TYPE_NONE);

        $client->setName('FixtureClient55');

        $manager->persist($client);

        $client = new Client();

        //set id metadata
        $metadata = $manager->getClassMetadata(get_class($client));
        $metadata->setIdGenerator(new \Doctrine\ORM\Id\AssignedGenerator());
        $metadata->setIdGeneratorType(\Doctrine\ORM\Mapping\ClassMetadata::GENERATOR_TYPE_NONE);
        
        $client->setId(66);
        $client->setName('FixtureClient66');

        $manager->persist($client);

        $manager->flush();
    }
}
