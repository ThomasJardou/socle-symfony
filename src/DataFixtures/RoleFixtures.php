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
            ->setSlug('ROLE_ADMIN');

        $manager->persist($item);

        $manager->flush();
    }
}
