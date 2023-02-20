<?php

namespace App\DataFixtures;

use App\Entity\Checklist;
use App\Entity\Item;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ItemFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        foreach ($this->getData() as $data) {
            /** @var Checklist $checklist */
            $checklist = $this->getReference($data[2]);

            $item = new Item();
            $item
                ->setName($data[0])
                ->setDone($data[1])
            ;

            $checklist->addItem($item);

            $manager->persist($item);
        }

        $manager->flush();
    }

    private function getData(): array
    {
        return [
            ['Naruto', true, 'Mangas à lire'],
            ['Bleach', true, 'Mangas à lire'],
            ['One punch man', false, 'Mangas à lire'],
        ];
    }

    public function getDependencies(): array
    {
        return [
            ChecklistFixtures::class,
        ];
    }
}
