<?php

namespace App\Controller;

use Psr\Cache\CacheItemInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

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
    public function browse(HttpClientInterface $httpClient, CacheInterface $cache, string $slug = null): Response
    {
        $genre = $slug ? u(str_replace('-', ' ', $slug))->title(true) : 'All Geres';
        $mixes = $cache->get('mixes_data', function (CacheItemInterface $cacheItem) use ($httpClient) {
            $cacheItem->expiresAfter(5);
            $response = $httpClient->request('GET', 'https://raw.githubusercontent.com/SymfonyCasts/vinyl-mixes/main/mixes.json');
            return $response->toArray();
        });

        return $this->render('vinyl/browse.html.twig', [
            'genre' => $genre,
            'mixes' => $mixes
        ]);
    }

}