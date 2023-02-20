<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        foreach ($this->getData() as $data) {
            $category = new Category();
            $category
                ->setName($data[0])
                ->setColor($data[1])
            ;

            $this->addReference($data[0], $category);

            $manager->persist($category);
        }

        $manager->flush();
    }

    private function getData(): array
    {
        return [
            ['Mangas', 'yellow'],
            ['Films', 'brown'],
            ['Livres', null],
        ];
    }
}
