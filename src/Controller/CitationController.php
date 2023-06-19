<?php

namespace App\Controller;

use App\Entity\Citation;
use App\Repository\CitationRepository;
use App\Service\CallKaamelott;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/')]
class CitationController extends AbstractController
{
    #[Route('/', name: 'app_citation')]
    public function index(CallKaamelott $callKaamelott): Response
    {
        $fetchCitation = $callKaamelott->fetchKaamelott();

        //dd($fetchCitation);

        return $this->render('citation/index.html.twig', [
            'citation' => $fetchCitation,
        ]);
    }

    #[Route('/populary', name: 'populary_quotes')]
    public function populary(CitationRepository $citationRepository, Request $request): Response
    {
        $citationPopulaires = $citationRepository->findBy(array(), ["countSave"=>"DESC"], 3, null);

        return $this->render('citation/populary.html.twig', [
            'citations' => $citationPopulaires,
        ]);
    }

    #[Route('/save', name: 'app_citation_save_by_user')]
    public function save2(CitationRepository $citationRepository, Request $request, EntityManagerInterface $manager): Response
    {

        $value = $request->get("content");
        $charactere = $request->get("character");

        $quote = $citationRepository->findOneBySomeField($value);

        if (!$quote){
            $quote = new Citation();
            $quote->setQuote($value);
            $quote->setCaractere($charactere);
            $quote->addAuthor($this->getUser());
            $quote->setCountSave(+1);
        }
        else {
            $this->getUser()->addCitation($quote);
        }

        $manager->persist($quote);
        $manager->flush();

        return $this->redirectToRoute('app_citation');
    }

    #[Route('/delete/{id}', name: 'delete_quote_by_user')]
    #[Route('/admin/deleteByAdmin/{id}', name: 'delete_quote')]
    public function deleteUser(Citation $citation, Request $request, EntityManagerInterface $manager): Response
    {
        if($request->get('_route') === 'delete_quote') {

            $manager->remove($citation);
            $manager->flush();

            return $this->redirectToRoute('app_user_index');
        }

        else {
            if ($citation) {
                $citation->getCountSave()-1;
                $this->getUser()->removeCitation($citation);
            }

            return $this->redirectToRoute('app_user_quotes', ['id'=>$this->getUser()->getId()]);
        }
    }
}
