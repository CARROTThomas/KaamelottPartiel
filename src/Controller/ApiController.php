<?php

namespace App\Controller;

use App\Repository\CitationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApiController extends AbstractController
{
    #[Route('/api/citation', name: 'app_api')]
    public function index(CitationRepository $citationRepository): Response
    {
        $citationPopulaires = $citationRepository->findBy(array(), ["countSave"=>"DESC"], 3, null);
        return $this->json($citationPopulaires, 200, [], ['groups' =>'quote:read']);
    }
}
