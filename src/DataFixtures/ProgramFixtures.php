<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Program;
use App\DataFixtures\CategoryFixtures;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ProgramFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        for ($i = 0; $i < 50; $i++) {
            $program = new Program();
            $program->setTitle($faker->sentence());
            $program->setSynopsis($faker->paragraphs(3, true));
            $randomCategoryKey = array_rand(CategoryFixtures::CATEGORIES);
            $categoryName = CategoryFixtures::CATEGORIES[$randomCategoryKey];
            $program->setCategory($this->getReference('category_' . $categoryName));
            $this->addReference('program_' . $i, $program);
            $manager->persist($program);
        }
        $manager->flush();
    }
    public function getDependencies(): array
    {
        return [
            CategoryFixtures::class,
        ];
    }
}
