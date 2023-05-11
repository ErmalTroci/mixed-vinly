<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use function Symfony\Component\String\u;


class VinylController extends AbstractController
{
    #[Route('/')]
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

    #[Route('/browse/{slug}')]
    public function browse(string $slug = null): Response
    {
        $title = $slug ? 'Genre: '.u(str_replace('-', ' ', $slug))->title(true) : 'All Geres';
        return new Response($title);
    }
}