<?php

namespace App\DataFixtures;

use App\Entity\Contact;
use App\Entity\Note;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class NoteFixtures extends BaseFixture implements DependentFixtureInterface
{
    protected function loadData(ObjectManager $manager): void
    {
        $contacts = $manager->getRepository(Contact::class)->findAll();

        $this->createMany(Note::class, 930, function (Note $note) use ($contacts) {
            $note->setName($this->faker->sentence(3));
            $note->setContent($this->faker->realText());
            $note->setContact($this->faker->randomElement($contacts));
        });

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            ContactFixtures::class,
        ];
    }
}
