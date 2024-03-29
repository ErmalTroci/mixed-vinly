<?php

namespace App\Controller;

use App\Repository\VinylMixRepository;
use Pagerfanta\Doctrine\ORM\QueryAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use function Symfony\Component\String\u;


class VinylController extends AbstractController
{   
    #[Route('/', name: 'app_homepage')]
    public function homepage(): Response
    {
        $tracks = [
            ['song' => 'MORNING LIGHT', 'artist' => 'JUSTIN TIMBERLAKE & ALICIA KEYS'],
            ['song' =>'BONNIE & CLYDE ', 'artist' => ' JAY-Z & BEYONCE'],
            ['song' =>'SCARTISSUE ', 'artist' => ' RED HOT CHILI PEPPERS'],
            ['song' =>'LOVE IS THE NEW MONEY ', 'artist' => ' ANDY GRAMMER'],
            ['song' =>'E DUA ', 'artist' => ' VEDAT ADEMI X KLEJTI MAHMUTAJ'],
            ['song' => 'Habibi', 'artist' => 'Anxhela Peristeri']
        ];

        return $this->render('vinyl/homepage.html.twig', [
            'title' => 'PB and jams',
            'tracks' => $tracks,
        ]);
    }

    #[Route('/browse/{slug}', name: 'app_browse')]
    public function browse(VinylMixRepository $mixRepository, Request $request, string $slug = null): Response
    {
        $genre = $slug ? u(str_replace('-', ' ', $slug))->title(true) : 'All Geres';

        $qb = $mixRepository->createOrderdByVotesQueryBuilder($slug);
        $adapter = new QueryAdapter($qb);
        $pagerfanta = Pagerfanta::createForCurrentPageWithMaxPerPage(
            $adapter,
            $request->query->get('page', 1),
            9
        );
        return $this->render('vinyl/browse.html.twig', [
            'genre' => $genre,
            'pager' => $pagerfanta
        ]);
    }

}