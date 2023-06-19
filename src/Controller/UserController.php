<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\CitationRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/user')]
class UserController extends AbstractController
{
    #[Route('/', name: 'app_user_index', methods: ['GET'])]
    public function index(UserRepository $userRepository, CitationRepository $citationRepository): Response
    {
        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findAll(),
            'citations'=> $citationRepository->findAll(),
        ]);
    }

    #[Route('/promote/{id}', name: 'app_user_promote')]
    #[Route('/demote/{id}', name: 'app_user_demote')]
    public function test(Request $request, User $user, UserRepository $userRepository): Response
    {
        $promote = true;

        if($request->get('_route') === 'app_user_demote') {
            $promote = false ;
        }

        if($promote){
            $user->setRoles(["ROLE_ADMIN"]);
        }

        else{
            $user->setRoles([]);
        }

        $userRepository->save($user,true);

        return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/userquotes/{id}', name: 'app_user_quotes')]
    public function userQuotes(User $user): Response
    {
        return $this->render('citation/show.html.twig', [
            'citations' => $user->getCitations(),
        ]);
    }
}
