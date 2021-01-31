<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProfileController extends AbstractController
{
    /**
     * @Route("/profile", name="app_profile", methods={"GET"})
     * @Security("is_granted('IS_AUTHENTICATED_REMEMBERED')")
     */
    public function profile(Request $request): Response
    {
        return $this->render('profile/profile.html.twig', []);
    }
}
