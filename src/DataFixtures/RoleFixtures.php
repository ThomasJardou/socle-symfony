<?php

namespace App\DataFixtures;

use App\Domain\Core\Entity\Role;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class RoleFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $item = new Role();
        $item->setName('Administrateur')
            ->setSlug('ROLE_ADMINISTRATEUR');

        $item2 = new Role();
        $item2->setName('Membre')
            ->setSlug('ROLE_MEMBRE');

        $manager->persist($item);
        $manager->persist($item2);

        $manager->flush();
    }
}
