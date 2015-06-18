<?php

namespace TestWebServiceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{
    /**
     * @Route("/notes")
     * @Template()
     */
    public function indexAction()
    {
        $client = $this->get('guzzle.client');
		$request = $client->get('http://sfrest.local/app_dev.php/notes.json');
		$response = $request->send();
		$json = $response->getBody();
		
		$data = json_decode($json, true);
		
		return array('response' => $response, 'json' => $json, 'data' => $data);
    }
}
