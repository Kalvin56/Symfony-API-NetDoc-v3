<?php

namespace App\DataFixtures;

use App\Entity\Domain;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

        $domains = ['Dentiste', 'Médecin généraliste', 'Algologue', 'Ophtalmologue', 'Podologue', 'Médecin du sport'];

        // $product = new Product();
        // $manager->persist($product);

        for($i=0; $i < count($domains); $i++) { 
            $domain = new Domain();
            $domain->setDomainName($domains[$i]);
            $manager->persist($domain);
        }

        $manager->flush();
    }
}
