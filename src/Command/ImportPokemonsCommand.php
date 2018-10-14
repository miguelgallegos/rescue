<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

use App\Entity\Pokemon;
use App\Entity\PokemonType;

use Doctrine\ORM\EntityManagerInterface;

class ImportPokemonsCommand extends Command
{
    protected static $defaultName = 'app:import-pokemons';

    private $entityManager;

    public function __construct(EntityManagerInterface $em) {
        $this->entityManager = $em;

        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription('Add a short description for your command')
            ->addArgument('s', InputArgument::OPTIONAL, 'Pokemons source JSON file')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $arg1 = $input->getArgument('s');

        if ($arg1) {

            if (strpos($arg1, 'pokemon.json') === false) {
                $io->error('Invalid Pokemons JSON file...');   
                die();                
            }

            $io->note(sprintf('Downloading JSON file from %s', $arg1));
            $url = $arg1;
        } else {
            $io->error('Please specify Pokemons JSON file...');   
            die();
        }

        // $url = 'https://gist.githubusercontent.com/andygroff/274283a38f2786796df57e11738d6bba/raw/f8eb9332ac08a4ee75767bcd76904f001cb6ec37/pokemon.json';
        $poks = json_decode(file_get_contents($url), true);

        $n = 0;

        $availablePokemons = [];
        $availablePokemonTypes = [];
        $pokemonRepo = $this->entityManager->getRepository(Pokemon::class);
        $pokemonTypeRepo = $this->entityManager->getRepository(PokemonType::class);

        //TODO: add check if exists OR wipe out all DB if running the command again!
        foreach ($poks as $pok) {
            $aPokemon = new Pokemon();
            $aPokemon->setName(ucfirst($pok['name']));
            $aPokemon->setSlug($pok['name']);

            foreach ($pok['types'] as $ptype) {
                if (isset($availablePokemonTypes[$ptype])) {
                    $aPokeType = $availablePokemonTypes[$ptype];
                } else {
                    $aPokeType = new PokemonType();
                    $aPokeType->setName($ptype);
                    $availablePokemonTypes[$ptype] = $aPokeType;
                    $this->entityManager->persist($aPokeType);
                }

                $aPokemon->addType($aPokeType);
            }

            $this->entityManager->persist($aPokemon);
            $this->entityManager->flush();
            $n ++;
        }

        $io->success("Imported $n pokemons.");
    }
}
