<?php

namespace App\DataFixtures;

use App\Entity\Program;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ProgramFixtures extends Fixture implements DependentFixtureInterface
{
    const PROGRAMS = [
        [
            'title' => 'Walking dead',
            'synopsis' => 'Des zombies envahissent la terre',
            'category' => 'category_Action',
        ],
        [
            'title' => 'Squid game',
            'synopsis' => 'Série coréenne',
            'category' => 'category_Action',
        ],
        [
            'title' => 'See',
            'synopsis' => 'Plus personne ne peut voir',
            'category' => 'category_Horreur',
        ],
        [
            'title' => 'Les animaux fantastiques',
            'synopsis' => 'Dans une terre lointaine',
            'category' => 'category_Fantastique',
        ],
        [
            'title' => 'Indiana Jones',
            'synopsis' => 'Dans un temple maya',
            'category' => 'category_Action',
        ],
    ];
    
    public function load(ObjectManager $manager)
    {
       foreach (self::PROGRAMS as $programData) {
           $program = new Program();
           $program->setTitle($programData['title']);
           $program->setSynopsis($programData['synopsis']);
           $program->setCategory($this->getReference($programData['category']));
    
           $manager->persist($program);
           $this->addReference('program_' . $programData['title'], $program);
       }
    
       $manager->flush();
    }
    
    public function getDependencies()
    {
        return [
            CategoryFixtures::class,
        ];
    }
}
