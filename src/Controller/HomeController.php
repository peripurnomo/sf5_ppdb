<?php

namespace App\Controller;

use App\Repository\PostRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    private $postRepo;

    public function __construct(PostRepository $postRepository)
    {
    	$this->postRepo = $postRepository;
    }
	  
    /**
     * @Route("/", name="app_home", methods={"GET"})
 	 * @Security("is_granted('IS_AUTHENTICATED_REMEMBERED')")
     */
    public function home(Request $request): Response
    {
        return $this->render('home/index.html.twig', [
        	'posts' => $this->postRepo->findAll()
        ]);
    }
}
