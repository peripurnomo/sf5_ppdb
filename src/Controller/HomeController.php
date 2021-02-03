<?php

namespace App\Controller;

use App\Repository\PostRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Security("is_granted('IS_AUTHENTICATED_REMEMBERED')")
 */
final class HomeController extends AbstractController
{
    private $postRepo;

    public function __construct(PostRepository $postRepository)
    {
    	$this->postRepo = $postRepository;
    }
	  
    /**
     * @Route("/", name="app_home", methods={"GET"})
     */
    public function home(Request $request): Response
    {
        return $this->render('home/index.html.twig', [
        	'posts' => $this->postRepo->findAll()
        ]);
    }
}
