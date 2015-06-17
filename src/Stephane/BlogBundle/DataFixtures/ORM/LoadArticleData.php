<?php

namespace StephaneBlogBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Stephane\BlogBundle\Entity\Article;

class LoadArticleData implements FixtureInterface {
	
	public function load(ObjectManager $manager) {
		$article = new Article ();
		
		$article->setTitre ( 'Test de création d\'un article' )->setContenu ( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc gravida posuere nunc. Nulla vestibulum, risus ac faucibus consequat, odio neque ornare metus, sed placerat est nisi vel felis. Aenean viverra sed mi quis fringilla. Ut quis massa egestas, volutpat ipsum ac, laoreet metus. In hac habitasse platea dictumst. Proin euismod nunc ut ipsum tristique condimentum. Suspendisse tortor mi, dapibus in tincidunt id, egestas at dui.' )->setAuteur ( 'Crée par le fixture pour le test' );
		
		$manager->persist ( $article );
		$manager->flush ();
	}
}