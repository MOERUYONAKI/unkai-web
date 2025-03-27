<?php

namespace App\Controller;

use AllowDynamicProperties;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

#[AllowDynamicProperties] class IndexController extends AbstractController
{
    public function __construct()
    {
        $filePath = '../assets/docs/personnages.json';

        if (file_exists($filePath)) {
            $this->personnages = json_decode(file_get_contents($filePath), true);
        } else {
            $this->personnages = [];
        }
    }

    #[Route('/', name: 'index')]
    public function index(
        Request $request
    ): Response
    {
        $theme = 'dark';

        if ($request->query->has('theme')) {
            $new = $request->query->get('theme');

            if ($new == "light") {
                $theme = 'light';
            }
        }

        return $this->render('Page/index.html.twig', [
            'theme' => $theme
        ]);
    }

    #[Route('/docs', name: 'docs')]
    public function docs(
        Request $request
    ): Response
    {
        $theme = 'dark';

        if ($request->query->has('theme')) {
            $new = $request->query->get('theme');

            if ($new == "light") {
                $theme = 'light';
            }
        }

        if ($request->query->has('search')) {
            $search = $request->query->get('search');
            $personnages = [];

            foreach ($this->personnages as $personnage) {
                if (str_contains(strtolower($personnage["nom"]), strtolower($search))) {
                    array_push($personnages, $personnage);

                } else {
                    foreach ($personnage["categorie"] as $categorie) {
                        if (str_contains(strtolower($categorie), strtolower($search)) && !in_array($personnage, $personnages)) {
                            array_push($personnages, $personnage);
                        }
                    }

                    foreach ($personnage["auteur"] as $auteur) {
                        if (str_contains(strtolower($auteur), strtolower($search)) && !in_array($personnage, $personnages)) {
                            array_push($personnages, $personnage);
                        }
                    }
                }
            }

            return $this->render('Page/docs.html.twig', [
                'personnages' => $personnages,
                'theme' => $theme
            ]);
            
        } else {
            return $this->render('Page/docs.html.twig', [
                'personnages' => $this->personnages,
                'theme' => $theme
            ]);
        }
    }

    #[Route('/serveurs', name: 'serveurs')]
    public function serveurs(
        Request $request
    ): Response
    {
        $theme = 'dark';

        if ($request->query->has('theme')) {
            $new = $request->query->get('theme');

            if ($new == "light") {
                $theme = 'light';
            }
        }

        return $this->render('Page/serveurs.html.twig', [
            'theme' => $theme
        ]);
    }

    #[Route('/api/personnages', name: 'get_personnages')]
    public function getPersonnages(): JsonResponse
    {
        $filePath = $this->getParameter('kernel.project_dir') . '/assets/docs/personnages.json';

        if (!file_exists($filePath)) {
            return new JsonResponse(['error' => 'File not found'], 404);
        }

        $data = file_get_contents($filePath);
        return new JsonResponse(json_decode($data, true));
    }
}