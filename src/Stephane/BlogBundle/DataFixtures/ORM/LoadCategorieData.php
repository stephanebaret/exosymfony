<?php

namespace StephaneBlogBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Stephane\BlogBundle\Entity\Categorie;

class LoadCategorieData implements FixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $categorie = new Categorie();
        $categorie->setNom('test slacker');

        $manager->persist($categorie);
        $manager->flush();
    }
}