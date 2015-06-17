<?php

namespace Stephane\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Stephane\BlogBundle\Entity\Article;
use Stephane\BlogBundle\Entity\Image;
use Stephane\BlogBundle\Entity\Commentaire;
use Stephane\BlogBundle\Entity\Categorie;
use Stephane\BlogBundle\Form\ArticleType;
use Symfony\Component\Validator\Constraints\Type;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/Blog")
 */
class BlogController extends Controller {
	/**
	 * Liste tous les articles
	 *
	 * @Route("/", name="article_blog")
	 * @Method("GET")
	 * @Template()
	 */
	public function indexAction() {
		$em = $this->getDoctrine ()->getManager ();
		$entities = $em->getRepository ( 'StephaneBlogBundle:Article' )->findAll ();
		return array (
				'listeArticles' => $entities 
		);
	}
	
	/**
	 * @Route("/article/{id}", name="stephane_blog_voir", requirements={"id" = "\d+"})
	 * @Route("/article/{slug}", name="stephane_blog_voir_slug")
	 * @Template()
	 */
	
	// * @Template(StephaneBlogBundle:Blog:voir.html.twig) si nommer n'importe comment
	public function voirAction(Article $article) {
		return array (
				'article' => $article 
		);
	}
	
	/**
	 * @Route("/articles/", name="stephane_blog_voir_all")
	 * @Template()
	 */
	public function voirAllAction(Request $request) {
		$em    = $this->get('doctrine.orm.entity_manager');
		$dql   = "SELECT a FROM StephaneBlogBundle:Article a";
		$query = $em->createQuery($dql);
		
		$paginator  = $this->get('knp_paginator');
		$pagination = $paginator->paginate(
				$query,
				$request->query->getInt('page', 1)/*page number*/,
				3/*limit per page*/
		
		);

	    // parameters to template
	    return $this->render('StephaneBlogBundle:Blog:list.html.twig', array('pagination' => $pagination));
	}
	
	/**
	 * @Route("/ajouter", name="stephane_blog_ajouter")
	 * @Template()
	 */
	public function ajouterAction() {
		$article = new Article ();
		
		// $form = $this->createForm(new ArticleType, $article);
		
		$formBuilder = $this->createFormBuilder ( $article );
		$formBuilder->add ( 'titre', 'text' )->add ( 'contenu', 'textarea' )->add ( 'auteur', 'text' )->add ( 'datecreation', 'datetime' )->add ( 'publication', 'checkbox' );
		$form = $formBuilder->getForm ();
		
		$request = $this->getRequest ();
		if ($request->getMethod () == "POST") {
			$form->handleRequest ( $request );
			
			if ($form->isValid ()) {
				// g�n�ration du slugg
// 				$slugger = $this->get('stephane_blog.slugger');
// 				$slug = $slugger->getSlug($article->getTitre());
// 				$article->setSlug($slug);
				
				$entityManager = $this->getDoctrine ()->getManager ();
				$entityManager->persist ( $article );
				$entityManager->flush ();
				return $this->redirect ( $this->generateUrl ( 'stephane_blog_voir', array (
						'id' => $article->getId () 
				) ) );
			} else {
			}
		}
		
		// $image = new Image;
		// $image->setSrc("tof1.jpg");
		// $image->setAlt("tof1");
		//
		return $this->render ( 'StephaneBlogBundle:Blog:ajouter.html.twig', array (
				'form' => $form->createView () 
		) );
	}
	
	/**
	 * @Route("/modifier/{id}", name="stephane_blog_modifier", requirements={"id" = "\d+"})
	 * @Template()
	 */
	public function modifierAction(Article $article) {
		
		// $form = $this->createForm(new ArticleType, $article);
		
		$formBuilder = $this->createFormBuilder ( $article );
		$formBuilder->add ( 'titre', 'text' )->add ( 'contenu', 'textarea' )->add ( 'auteur', 'text' )->add ( 'datecreation', 'datetime' )->add ( 'publication', 'checkbox' );
		$form = $formBuilder->getForm ();
		
		$request = $this->getRequest ();
		if ($request->getMethod () == "POST") {
			$form->handleRequest ( $request );
			
			if ($form->isValid ()) {
				// g�n�ration du slugg
// 				$slugger = $this->get('stephane_blog.slugger');
// 				$slug = $slugger->getSlug($article->getTitre());
// 				$article->setSlug($slug);
				
				$entityManager = $this->getDoctrine ()->getManager ();
				$entityManager->persist ( $article );
				$entityManager->flush ();
				return $this->redirect ( $this->generateUrl ( 'stephane_blog_voir', array (
						'id' => $article->getId () 
				) ) );
			} else {
			}
		}
		
		return $this->render ( 'StephaneBlogBundle:Blog:ajouter.html.twig', array (
				'form' => $form->createView () 
		) );
	}
	public function menuAction() {
		// $articles = array(
		// array('titre'=>'hello world 1', 'contenu'=>'Lorem ipsum dolor'),
		// array('titre'=>'hello world 2', 'contenu'=>'Lorem ipsum dolor'),
		// array('titre'=>'hello world 3', 'contenu'=>'Lorem ipsum dolor')
		// );
		$repository = $this->getDoctrine ()->getManager ()->getRepository ( 'StephaneBlogBundle:Article' );
		$articles = $repository->findBy ( array (
				'publication' => 1 
		), array (
				'datecreation' => 'desc' 
		), 3, 0 );
		return $this->render ( 'StephaneBlogBundle:Blog:menu.html.twig', array (
				'articles' => $articles 
		) );
	}
}
