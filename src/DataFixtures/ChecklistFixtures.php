<?php

namespace App\DataFixtures;

use App\Entity\Checklist;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ChecklistFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        foreach ($this->getData() as $data) {
            $checklist = new Checklist();
            $checklist
                ->setName($data[0])
                ->addCategory($data[1])
            ;

            $this->addReference($data[0], $checklist);

            $manager->persist($checklist);
        }

        $manager->flush();
    }

    private function getData(): array
    {
        return [
            ['Mangas à lire', $this->getReference('Mangas')],
            ['Films à voir', $this->getReference('Films')],
            ['Livres à lire', $this->getReference('Livres')],
        ];
    }

    public function getDependencies(): array
    {
        return [
            CategoryFixtures::class,
        ];
    }
}
