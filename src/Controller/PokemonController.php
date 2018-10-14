<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

use App\Repository\PokemonRepository;
use App\Repository\PokemonTypeRepository;

class PokemonController extends AbstractController
{
    /**
     * @Route("/pokemon", name="pokemon")
     */
    public function index(Request $request, PokemonRepository $pokRepo, PokemonTypeRepository $pokTypeRepo)
    {

        if (!$request->isXmlHttpRequest()) {
            return $this->render('pokemon/base.html.twig');
        }        

        $query = $request->query->get('q', '');

        $poks = $pokRepo->findBySlug($query);
        $pokTypes = $pokTypeRepo->findByName($query);

        foreach ($pokTypes as $pokType) {
            foreach ($pokType->getPokemons() as $pok) {
                if (! in_array($pok, $poks)) {
                    $poks[] = $pok;
                }
            }
        }

        $allPoks = [];

        //$allPoks = PokemonManager->formatResults()

        //do replacings!
        foreach ($poks as $pok) {
            $aPok = [
                'name' => str_replace($query, "<strong>$query</strong>", $pok->getName()),
            ];

            $types = [];
            foreach ($pok->getTypes() as $type) {
                $t['name'] = str_replace($query, "<strong>$query</strong>", $type->getName());
                $types[] = $t;
            }
            $aPok['types'] = $types;

            $allPoks[] = $aPok;
        }


        return $this->render('pokemon/results.html.twig', ['pokemons' => $allPoks, 'highlight' => $query]);
    }

}
